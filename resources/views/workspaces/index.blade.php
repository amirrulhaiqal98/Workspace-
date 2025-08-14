@extends('layouts.admin')

@section('page-title', 'Workspaces')

@section('breadcrumb')
    <li class="breadcrumb-item active">Workspaces</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Workspaces</h3>
                    <div class="card-tools">
                        @can('create', App\Models\Workspace::class)
                            <a href="{{ route('workspaces.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Create Workspace</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    @if($workspaces->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No workspaces yet</h4>
                            <p class="text-muted">Create your first workspace to start organizing your tasks.</p>
                            @can('create', App\Models\Workspace::class)
                                <a href="{{ route('workspaces.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Your First Workspace
                                </a>
                            @endcan
                        </div>
                    @else
                        <!-- Mobile Card View (visible on mobile only) -->
                        <div class="d-md-none">
                            @foreach($workspaces as $workspace)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">
                                                <a href="{{ route('workspaces.show', $workspace) }}" class="text-decoration-none">
                                                    <i class="fas fa-folder-open text-primary"></i> {{ $workspace->name }}
                                                </a>
                                            </h5>
                                            <div class="dropdown">
                                                <button class="btn btn-link btn-sm" type="button" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('view', $workspace)
                                                        <a href="{{ route('workspaces.show', $workspace) }}" class="dropdown-item">
                                                            <i class="fas fa-eye text-info"></i> View
                                                        </a>
                                                    @endcan
                                                    @can('update', $workspace)
                                                        <a href="{{ route('workspaces.edit', $workspace) }}" class="dropdown-item">
                                                            <i class="fas fa-edit text-warning"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('delete', $workspace)
                                                        <div class="dropdown-divider"></div>
                                                        <form method="POST" action="{{ route('workspaces.destroy', $workspace) }}" class="dropdown-item p-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger w-100 text-left p-3" 
                                                                    onclick="return confirm('Are you sure you want to delete this workspace? All tasks will be deleted too.')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($workspace->description)
                                            <p class="card-text text-muted small mb-2">
                                                {{ Str::limit($workspace->description, 80) }}
                                            </p>
                                        @endif
                                        
                                        <div class="row text-center mb-2">
                                            <div class="col-4">
                                                <div class="d-flex flex-column">
                                                    <span class="badge badge-info badge-pill">{{ $workspace->tasks_count }}</span>
                                                    <small class="text-muted">Tasks</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex flex-column">
                                                    <span class="badge badge-success badge-pill">{{ $workspace->completed_tasks_count }}</span>
                                                    <small class="text-muted">Done</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex flex-column">
                                                    <span class="badge badge-warning badge-pill">{{ $workspace->incomplete_tasks_count }}</span>
                                                    <small class="text-muted">Pending</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> {{ $workspace->created_at->format('M d, Y') }}
                                            </small>
                                            <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-primary btn-sm">
                                                Open <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-bordered table-striped table-hover" id="workspacesTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th><i class="fas fa-folder"></i> Name</th>
                                        <th><i class="fas fa-align-left"></i> Description</th>
                                        <th><i class="fas fa-tasks"></i> Tasks</th>
                                        <th><i class="fas fa-check-circle"></i> Completed</th>
                                        <th><i class="fas fa-clock"></i> Pending</th>
                                        <th><i class="fas fa-calendar-plus"></i> Created</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workspaces as $workspace)
                                        <tr>
                                            <td>
                                                <a href="{{ route('workspaces.show', $workspace) }}" class="font-weight-bold text-primary">
                                                    <i class="fas fa-folder-open"></i> {{ $workspace->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ Str::limit($workspace->description, 50) ?: 'No description' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info badge-pill">
                                                    {{ $workspace->tasks_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success badge-pill">
                                                    {{ $workspace->completed_tasks_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-warning badge-pill">
                                                    {{ $workspace->incomplete_tasks_count }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar"></i> {{ $workspace->created_at->format('M d, Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @can('view', $workspace)
                                                        <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('update', $workspace)
                                                        <a href="{{ route('workspaces.edit', $workspace) }}" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete', $workspace)
                                                        <form method="POST" action="{{ route('workspaces.destroy', $workspace) }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                                    onclick="return confirm('Are you sure you want to delete this workspace? All tasks will be deleted too.')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                @if($workspaces->hasPages())
                    <div class="card-footer">
                        {{ $workspaces->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection