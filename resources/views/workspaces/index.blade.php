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
                                <i class="fas fa-plus"></i> Create Workspace
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Tasks</th>
                                        <th>Completed</th>
                                        <th>Pending</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workspaces as $workspace)
                                        <tr>
                                            <td>
                                                <a href="{{ route('workspaces.show', $workspace) }}" class="font-weight-bold">
                                                    {{ $workspace->name }}
                                                </a>
                                            </td>
                                            <td>{{ Str::limit($workspace->description, 50) ?: '-' }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $workspace->tasks_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $workspace->completed_tasks_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">{{ $workspace->incomplete_tasks_count }}</span>
                                            </td>
                                            <td>{{ $workspace->created_at->format('M d, Y') }}</td>
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