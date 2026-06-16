<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $task->load('project.team');

        if (! Auth::user()->teams->contains($task->project->team)) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        Comment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
}
