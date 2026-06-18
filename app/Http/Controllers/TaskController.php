<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private function checkAccess(Project $project): void
    {
        $user = Auth::user();

        if (! $user instanceof User || ! $user->teams->contains($project->team)) {
            abort(403);
        }
    }

    public function store(Request $request, Project $project)
    {
        $this->checkAccess($project);

        $validated = $this->validateTask($request);

        Task::create([
            'project_id' => $project->id,
            'assigned_user_id' => Auth::id(),
            'created_by' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $this->checkAccess($task->project);

        $task->update($this->validateTask($request));

        return redirect()->back();
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->checkAccess($task->project);

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,testing,done',
        ]);

        $task->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => $task->status,
            ]);
        }

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $this->checkAccess($task->project);

        $task->delete();

        return redirect()->back();
    }

    private function validateTask(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:todo,in_progress,testing,done',
        ]);
    }
}
