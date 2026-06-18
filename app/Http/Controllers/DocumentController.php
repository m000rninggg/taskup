<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
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

        $validated = $request->validate([
            'request_token' => 'required|uuid',
            'title' => 'required|string|max:255',
            'category' => 'required|in:main,additional',
            'content' => 'nullable|string',
        ]);

        Document::firstOrCreate(
            [
                'project_id' => $project->id,
                'request_token' => $validated['request_token'],
            ],
            [
                'updated_by' => Auth::id(),
                'title' => $validated['title'],
                'category' => $validated['category'],
                'content' => $validated['content'] ?? null,
            ]
        );

        return redirect()->route('projects.doc', $project);
    }

    public function update(Request $request, Document $document)
    {
        $this->checkAccess($document->project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:main,additional',
            'content' => 'nullable|string',
        ]);

        $document->update([
            ...$validated,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('projects.doc', $document->project);
    }

    public function destroy(Document $document)
    {
        $this->checkAccess($document->project);

        $project = $document->project;
        $document->delete();

        return redirect()->route('projects.doc', $project);
    }
}
