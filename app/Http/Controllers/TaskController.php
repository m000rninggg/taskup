<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Task::create([
            'project_id' => $project->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'todo',
        ]);

        return redirect()->back();
    }
}