<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $workspaceCount = $user->workspaces()->count();
    $totalTasks = $user->workspaces()->withCount('tasks')->get()->sum('tasks_count');
    $completedTasks = $user->workspaces()->with(['tasks' => function($query) {
        $query->where('status', 'completed');
    }])->get()->sum(function($workspace) {
        return $workspace->tasks->count();
    });
    $pendingTasks = $totalTasks - $completedTasks;
    
    return view('dashboard', compact('workspaceCount', 'totalTasks', 'completedTasks', 'pendingTasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('workspaces', WorkspaceController::class);
    
    Route::middleware('workspace.owner')->group(function () {
        Route::resource('workspaces.tasks', TaskController::class)->except(['index', 'create']);
        Route::get('workspaces/{workspace}/tasks', [TaskController::class, 'index'])->name('workspaces.tasks.index');
        Route::get('workspaces/{workspace}/tasks/create', [TaskController::class, 'create'])->name('workspaces.tasks.create');
        Route::patch('workspaces/{workspace}/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('workspaces.tasks.toggle');
    });
});

require __DIR__.'/auth.php';
