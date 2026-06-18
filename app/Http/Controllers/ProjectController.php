<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private function checkAccess(Project $project): void
    {
        $user = Auth::user();

        if (! $user instanceof User || ! $user->teams->contains($project->team)) {
            abort(403);
        }
    }

    private function checkOwner(Project $project): void
    {
        abort_unless($project->team->owner_id === Auth::id(), 403);
    }

    public function index()
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        $userTeams = $user->teams;
        $projects = Project::with(['team', 'tasks'])
            ->whereIn('team_id', $userTeams->pluck('id'))
            ->latest()
            ->get();

        return view('projects.index', [
            'projects' => $projects,
            'teams' => $userTeams,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $user = Auth::user();

        abort_unless($user instanceof User && $user->teams()->whereKey($validated['team_id'])->exists(), 403);

        Project::create([
            'team_id' => $validated['team_id'],
            'created_by' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
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

        $project->load(['team.users', 'tasks']);

        return view('projects.main', compact('project'));
    }

    public function tasks(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['team.users', 'tasks.creator', 'tasks.assignedUser', 'tasks.comments.user']);

        return view('projects.tasks', compact('project'));
    }

    public function doc(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['team.users', 'documents.updater']);

        return view('projects.doc', compact('project'));
    }

    public function analytics(Project $project)
    {
        $this->checkAccess($project);

        $project->load(['team.users', 'tasks']);

        return view('projects.analytics', compact('project'));
    }

    public function settings(Project $project)
    {
        $this->checkOwner($project);

        $project->load('team.users');

        return view('projects.settings', compact('project'));
    }

    public function updateSettings(Request $request, Project $project)
    {
        $this->checkOwner($project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.settings', $project)
            ->with('status', 'Настройки проекта сохранены.');
    }

    public function addMember(Request $request, Project $project)
    {
        $this->checkOwner($project);

        $request->merge([
            'username' => strtolower(trim((string) $request->username)),
        ]);

        $validated = $request->validate([
            'username' => ['required', 'string', 'exists:users,username'],
        ]);

        $member = User::where('username', $validated['username'])->firstOrFail();
        $project->team->users()->syncWithoutDetaching([$member->id]);

        return redirect()
            ->route('projects.settings', $project)
            ->with('status', 'Пользователь добавлен в проект.');
    }

    public function destroy(Project $project)
    {
        $this->checkOwner($project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('status', 'Проект удалён.');
    }
}
