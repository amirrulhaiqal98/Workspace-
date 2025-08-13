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
                        <a href="{{ route('workspaces.tasks.create', $workspace) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Task
                        </a>
                        <a href="{{ route('workspaces.tasks.index', $workspace) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-list"></i> View All Tasks
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($workspace->tasks->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No tasks yet</h4>
                            <p class="text-muted">Add your first task to get started.</p>
                            <a href="{{ route('workspaces.tasks.create', $workspace) }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add First Task
                            </a>
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
                                    @foreach($workspace->tasks->take(10) as $task)
                                        <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                                            <td>
                                                <a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}">
                                                    {{ $task->title }}
                                                </a>
                                                @if($task->description)
                                                    <br><small class="text-muted">{{ Str::limit($task->description, 40) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {!! $task->status_badge !!}
                                            </td>
                                            <td>
                                                {{ $task->deadline->format('M d, Y H:i') }}
                                                <br><small class="text-muted">{{ $task->time_remaining }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <form method="POST" action="{{ route('workspaces.tasks.toggle', [$workspace, $task]) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-{{ $task->status === 'completed' ? 'warning' : 'success' }} btn-sm" title="{{ $task->status === 'completed' ? 'Mark as Incomplete' : 'Mark as Complete' }}">
                                                            <i class="fas fa-{{ $task->status === 'completed' ? 'undo' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('workspaces.tasks.edit', [$workspace, $task]) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($workspace->tasks->count() > 10)
                            <div class="card-footer text-center">
                                <a href="{{ route('workspaces.tasks.index', $workspace) }}" class="btn btn-primary">
                                    <i class="fas fa-list"></i> View All {{ $workspace->tasks->count() }} Tasks
                                </a>
                            </div>
                        @endif
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