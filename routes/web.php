<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');

});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    
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
    
    // WORKSPACE RESOURCE ROUTES FIRST (exclude conflicting ones)
    Route::resource('workspaces', WorkspaceController::class)->except(['show']);
    
    // TASK ROUTES WITH WORKSPACE OWNERSHIP MIDDLEWARE
    Route::middleware('workspace.owner')->group(function () {
        // Workspace show route (needs ownership check)
        Route::get('workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
        
        // Task routes (explicit paths to avoid conflicts)
        Route::get('workspaces/{workspace}/tasks', [TaskController::class, 'index'])->name('workspaces.tasks.index');
        Route::get('workspaces/{workspace}/tasks/create', [TaskController::class, 'create'])->name('workspaces.tasks.create');
        Route::post('workspaces/{workspace}/tasks', [TaskController::class, 'store'])->name('workspaces.tasks.store');
        Route::get('workspaces/{workspace}/tasks/{task}', [TaskController::class, 'show'])->name('workspaces.tasks.show');
        Route::get('workspaces/{workspace}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('workspaces.tasks.edit');
        Route::put('workspaces/{workspace}/tasks/{task}', [TaskController::class, 'update'])->name('workspaces.tasks.update');
        Route::patch('workspaces/{workspace}/tasks/{task}', [TaskController::class, 'update'])->name('workspaces.tasks.patch');
        Route::delete('workspaces/{workspace}/tasks/{task}', [TaskController::class, 'destroy'])->name('workspaces.tasks.destroy');
        Route::patch('workspaces/{workspace}/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('workspaces.tasks.toggle');
    });
});

require __DIR__.'/auth.php';
