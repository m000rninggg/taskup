<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $teamIds = $user->teams()->pluck('teams.id');
    $projectIds = Project::whereIn('team_id', $teamIds)->pluck('id');

    $upcomingDeadlines = Task::with('project')
        ->whereIn('project_id', $projectIds)
        ->where('assigned_user_id', $user->id)
        ->whereNotNull('deadline')
        ->where('status', '!=', 'done')
        ->whereDate('deadline', '>=', now()->toDateString())
        ->orderBy('deadline')
        ->limit(5)
        ->get();

    $myTasks = Task::with('project')
        ->whereIn('project_id', $projectIds)
        ->where('assigned_user_id', $user->id)
        ->where('status', '!=', 'done')
        ->latest()
        ->limit(5)
        ->get();

    return view('dashboard', [
        'upcomingDeadlines' => $upcomingDeadlines,
        'myTasks' => $myTasks,
        'statusLabels' => [
            'todo' => 'Идея',
            'in_progress' => 'В разработке',
            'testing' => 'В тесте',
            'done' => 'Готово',
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teams
    Route::post('/teams/{team}/members', [TeamController::class, 'addMember'])->name('teams.members.store');
    Route::resource('teams', TeamController::class)->only(['index', 'store']);

    // Project pages
    Route::get('/projects/{project}/main', [ProjectController::class, 'main'])->name('projects.main');
    Route::get('/projects/{project}/tasks', [ProjectController::class, 'tasks'])->name('projects.tasks');
    Route::get('/projects/{project}/doc', [ProjectController::class, 'doc'])->name('projects.doc');
    Route::get('/projects/{project}/analytics', [ProjectController::class, 'analytics'])->name('projects.analytics');
    Route::get('/projects/{project}/analitics', fn ($project) => redirect()->route('projects.analytics', $project));
    Route::get('/projects/{project}/settings', [ProjectController::class, 'settings'])->name('projects.settings');
    Route::patch('/projects/{project}/settings', [ProjectController::class, 'updateSettings'])->name('projects.settings.update');
    Route::post('/projects/{project}/members', [ProjectController::class, 'addMember'])->name('projects.members.store');
    Route::post('/projects/{project}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::patch('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Projects (упрощённые маршруты)
    Route::resource('projects', ProjectController::class)->only(['index', 'store', 'show', 'destroy']);

    // Tasks
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status.update');

    // Comments
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
