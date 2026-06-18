<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if (! $user instanceof User) {
            abort(403);
        }

        $projectsCount = Project::whereIn(
            'team_id',
            $user->teams()->pluck('teams.id')
        )->count();

        $activeTasksCount = Task::where('assigned_user_id', $user->id)
            ->whereIn('status', ['in_progress', 'testing'])
            ->count();

        $completedTasksCount = Task::where('assigned_user_id', $user->id)
            ->where('status', 'done')
            ->count();

        $overdueTasksCount = Task::where('assigned_user_id', $user->id)
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->where('status', '!=', 'done')
            ->count();

        return view('profile.edit', [
            'user' => $user,
            'projectsCount' => $projectsCount,
            'activeTasksCount' => $activeTasksCount,
            'completedTasksCount' => $completedTasksCount,
            'overdueTasksCount' => $overdueTasksCount,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
