<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $teams = $user->teams()
            ->with(['users', 'owner'])
            ->withCount('projects')
            ->latest()
            ->get();

        return view('teams.index', compact('teams'));
    }

    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'member_usernames' => ['nullable', 'string'],
        ]);

        $usernames = collect(explode(',', $validated['member_usernames'] ?? ''))
            ->map(fn (string $username) => strtolower(ltrim(trim($username), '@')))
            ->filter()
            ->unique()
            ->values();

        $members = User::whereIn('username', $usernames)->get();
        $foundUsernames = $members->pluck('username')
            ->map(fn (string $username) => strtolower($username));
        $missingUsernames = $usernames->diff($foundUsernames);

        if ($missingUsernames->isNotEmpty()) {
            throw ValidationException::withMessages([
                'member_usernames' => 'Пользователи не найдены: @'.$missingUsernames->join(', @'),
            ]);
        }

        DB::transaction(function () use ($validated, $user, $members): void {
            $team = Team::create([
                'name' => $validated['name'],
                'owner_id' => $user->id,
            ]);

            $team->users()->attach(
                $members->pluck('id')->push($user->id)->unique()->all()
            );
        });

        return redirect()
            ->route('teams.index')
            ->with('status', 'Команда создана.');
    }

    public function addMember(Request $request, Team $team): RedirectResponse
    {
        abort_unless($team->owner_id === auth()->id(), 403);

        $request->merge([
            'username' => strtolower((string) $request->username),
        ]);

        $validated = $request->validate([
            'username' => ['required', 'string', 'exists:users,username'],
        ]);

        $member = User::where('username', $validated['username'])->firstOrFail();

        $team->users()->syncWithoutDetaching([$member->id]);

        return redirect()
            ->route('teams.index')
            ->with('status', 'Пользователь добавлен в команду.');
    }
}
