<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;

class TeamController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $teams = $user->teams()->get();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'owner_id' => $user->id,
        ]);

        $team->users()->attach($user->id);

        return redirect()->route('teams.index');
    }
}