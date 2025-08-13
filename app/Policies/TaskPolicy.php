<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->workspace->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Workspace $workspace = null): bool
    {
        if (!$workspace) {
            return false;
        }
        
        $maxTasks = env('WORKSPACE_MAX_TASKS', 1000);
        return $user->id === $workspace->user_id && 
               $workspace->tasks()->count() < $maxTasks;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->workspace->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->workspace->user_id;
    }

    /**
     * Determine whether the user can toggle the task status.
     */
    public function toggle(User $user, Task $task): bool
    {
        return $user->id === $task->workspace->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->workspace->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $task->workspace->user_id;
    }
}
