<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        // Показываем проекты только из команд пользователя
        $userTeams = Auth::user()->teams;
        $projects = Project::whereIn('team_id', $userTeams->pluck('id'))->get();
        
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $teams = Auth::user()->teams;
        return view('projects.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Project::create([
            'team_id' => $request->team_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('projects.index')->with('success', 'Проект создан!');
    }

    public function show(Project $project)
    {
        // Проверяем, есть ли у пользователя доступ к команде проекта
        if (!Auth::user()->teams->contains($project->team)) {
            abort(403);
        }
        
        $project->load('tasks.comments.user');
        return view('projects.show', compact('project'));
    }
}