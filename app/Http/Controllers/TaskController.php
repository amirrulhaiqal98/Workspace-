<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Workspace $workspace): View
    {
        $this->authorize('view', $workspace);
        
        $tasks = $workspace->tasks()
            ->orderBy('deadline', 'asc')
            ->paginate(env('ITEMS_PER_PAGE', 15));

        return view('tasks.index', compact('workspace', 'tasks'));
    }

    public function create(Workspace $workspace): View
    {
        $this->authorize('view', $workspace);
        $this->authorize('create', [Task::class, $workspace]);
        
        return view('tasks.create', compact('workspace'));
    }

    public function store(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorize('view', $workspace);
        $this->authorize('create', [Task::class, $workspace]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'deadline' => 'required|date|after:now',
        ]);

        $validated['workspace_id'] = $workspace->id;

        Task::create($validated);

        return redirect()
            ->route('workspaces.tasks.index', $workspace)
            ->with('success', 'Task created successfully.');
    }

    public function show(Workspace $workspace, Task $task): View
    {
        $this->authorize('view', $workspace);
        $this->authorize('view', $task);
        $this->ensureTaskBelongsToWorkspace($task, $workspace);

        return view('tasks.show', compact('workspace', 'task'));
    }

    public function edit(Workspace $workspace, Task $task): View
    {
        $this->authorize('view', $workspace);
        $this->authorize('update', $task);
        $this->ensureTaskBelongsToWorkspace($task, $workspace);

        return view('tasks.edit', compact('workspace', 'task'));
    }

    public function update(Request $request, Workspace $workspace, Task $task): RedirectResponse
    {
        $this->authorize('view', $workspace);
        $this->authorize('update', $task);
        $this->ensureTaskBelongsToWorkspace($task, $workspace);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'deadline' => 'required|date|after:now',
        ]);

        $task->update($validated);

        return redirect()
            ->route('workspaces.tasks.show', [$workspace, $task])
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Workspace $workspace, Task $task): RedirectResponse
    {
        $this->authorize('view', $workspace);
        $this->authorize('delete', $task);
        $this->ensureTaskBelongsToWorkspace($task, $workspace);

        $task->delete();

        return redirect()
            ->route('workspaces.tasks.index', $workspace)
            ->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Workspace $workspace, Task $task): RedirectResponse
    {
        $this->authorize('view', $workspace);
        $this->authorize('toggle', $task);
        $this->ensureTaskBelongsToWorkspace($task, $workspace);

        if ($task->status === 'completed') {
            $task->markAsIncomplete();
            $message = 'Task marked as incomplete.';
        } else {
            $task->markAsCompleted();
            $message = 'Task marked as completed.';
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }

    private function ensureTaskBelongsToWorkspace(Task $task, Workspace $workspace): void
    {
        if ($task->workspace_id !== $workspace->id) {
            abort(404);
        }
    }
}
