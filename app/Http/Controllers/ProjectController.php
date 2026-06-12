<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private function checkAccess(Project $project): void
    {
        if (!Auth::user()->teams->contains($project->team)) {
            abort(403);
        }
    }

    public function index()
    {
        $userTeams = Auth::user()->teams;
        $projects = Project::with(['team', 'tasks'])
            ->whereIn('team_id', $userTeams->pluck('id'))
            ->latest()
            ->get();
        
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
        $this->checkAccess($project);

        return redirect()->route('projects.tasks', $project);
    }

    public function main(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['team', 'tasks']);
        return view('projects.main', compact('project'));
    }

    public function tasks(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['tasks.creator', 'tasks.assignedUser', 'tasks.comments.user']);
        return view('projects.tasks', compact('project'));
    }

    public function doc(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['team', 'documents.updater']);
        return view('projects.doc', compact('project'));
    }

    public function analitics(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['team', 'tasks']);
        return view('projects.analitics', compact('project'));
    }
}
