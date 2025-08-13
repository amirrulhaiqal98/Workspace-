@extends('layouts.admin')

@section('page-title', $workspace->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('workspaces.index') }}">Workspaces</a></li>
    <li class="breadcrumb-item active">{{ $workspace->name }}</li>
@endsection

@section('content')
    <!-- Workspace Info -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $workspace->tasks->count() }}</h3>
                    <p>Total Tasks</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $workspace->tasks->where('status', 'completed')->count() }}</h3>
                    <p>Completed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $workspace->tasks->where('status', 'incomplete')->count() }}</h3>
                    <p>Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $workspace->created_at->diffForHumans() }}</h3>
                    <p>Created</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Workspace Details -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tasks in this Workspace</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Task
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($workspace->tasks->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No tasks yet</h4>
                            <p class="text-muted">Add your first task to get started.</p>
                            <button class="btn btn-success">
                                <i class="fas fa-plus"></i> Add First Task
                            </button>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workspace->tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                @if($task->status === 'completed')
                                                    <span class="badge badge-success">Completed</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $task->deadline ? $task->deadline->format('M d, Y H:i') : 'No deadline' }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Workspace Details</h3>
                </div>
                <div class="card-body">
                    <strong>Name:</strong>
                    <p class="text-muted">{{ $workspace->name }}</p>

                    <strong>Description:</strong>
                    <p class="text-muted">{{ $workspace->description ?: 'No description provided' }}</p>

                    <strong>Created:</strong>
                    <p class="text-muted">{{ $workspace->created_at->format('M d, Y g:i A') }}</p>

                    <strong>Last Updated:</strong>
                    <p class="text-muted">{{ $workspace->updated_at->format('M d, Y g:i A') }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('workspaces.edit', $workspace) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Workspace
                    </a>
                    <form method="POST" action="{{ route('workspaces.destroy', $workspace) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure? All tasks will be deleted too.')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection