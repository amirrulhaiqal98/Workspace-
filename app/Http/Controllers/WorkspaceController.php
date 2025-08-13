<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkspaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $workspaces = Auth::user()->workspaces()
            ->withCount(['tasks', 'completedTasks', 'incompleteTasks'])
            ->orderBy('created_at', 'desc')
            ->paginate(env('ITEMS_PER_PAGE', 15));

        return view('workspaces.index', compact('workspaces'));
    }

    public function create(): View
    {
        return view('workspaces.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Workspace::create($validated);

        return redirect()
            ->route('workspaces.index')
            ->with('success', 'Workspace created successfully.');
    }

    public function show(Workspace $workspace): View
    {
        $this->authorize('view', $workspace);
        
        $workspace->load(['tasks' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('workspaces.show', compact('workspace'));
    }

    public function edit(Workspace $workspace): View
    {
        $this->authorize('update', $workspace);
        
        return view('workspaces.edit', compact('workspace'));
    }

    public function update(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorize('update', $workspace);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $workspace->update($validated);

        return redirect()
            ->route('workspaces.show', $workspace)
            ->with('success', 'Workspace updated successfully.');
    }

    public function destroy(Workspace $workspace): RedirectResponse
    {
        $this->authorize('delete', $workspace);

        $workspace->delete();

        return redirect()
            ->route('workspaces.index')
            ->with('success', 'Workspace deleted successfully.');
    }
}
