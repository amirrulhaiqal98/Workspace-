<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('workspaces', WorkspaceController::class);
    Route::resource('workspaces.tasks', TaskController::class)->except(['index', 'create']);
    Route::get('workspaces/{workspace}/tasks', [TaskController::class, 'index'])->name('workspaces.tasks.index');
    Route::get('workspaces/{workspace}/tasks/create', [TaskController::class, 'create'])->name('workspaces.tasks.create');
    Route::patch('workspaces/{workspace}/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('workspaces.tasks.toggle');
});

require __DIR__.'/auth.php';
