<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
})->name('csrf-token');

Route::get('/dashboard', function () {
    $projects = Project::with(['team', 'tasks'])
        ->whereIn('team_id', auth()->user()->teams()->pluck('teams.id'))
        ->latest()
        ->get();

    return view('dashboard', compact('projects'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Teams
    Route::resource('teams', TeamController::class);
    
    // Project pages
    Route::get('/projects/{project}/main', [ProjectController::class, 'main'])->name('projects.main');
    Route::get('/projects/{project}/tasks', [ProjectController::class, 'tasks'])->name('projects.tasks');
    Route::get('/projects/{project}/doc', [ProjectController::class, 'doc'])->name('projects.doc');
    Route::get('/projects/{project}/analitics', [ProjectController::class, 'analitics'])->name('projects.analitics');

    // Projects (упрощённые маршруты)
    Route::resource('projects', ProjectController::class)->only(['index', 'create', 'store', 'show']);
    
    // Tasks
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status.update');
    
    // Comments
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
