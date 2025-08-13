@extends('layouts.admin')

@section('page-title', $task->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('workspaces.index') }}">Workspaces</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.show', $workspace) }}">{{ $workspace->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.tasks.index', $workspace) }}">Tasks</a></li>
    <li class="breadcrumb-item active">{{ $task->title }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks"></i> {{ $task->title }}
                    </h3>
                    <div class="card-tools">
                        <form method="POST" action="{{ route('workspaces.tasks.toggle', [$workspace, $task]) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $task->status === 'completed' ? 'warning' : 'success' }} btn-sm">
                                <i class="fas fa-{{ $task->status === 'completed' ? 'undo' : 'check' }}"></i>
                                {{ $task->status === 'completed' ? 'Mark as Incomplete' : 'Mark as Complete' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-sm-9">
                            {!! $task->status_badge !!}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Deadline:</strong>
                        </div>
                        <div class="col-sm-9">
                            <i class="fas fa-calendar"></i>
                            {{ $task->deadline->format('M d, Y g:i A') }}
                            @if($task->is_overdue && $task->status === 'incomplete')
                                <span class="badge badge-danger ml-2">OVERDUE</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Time Status:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($task->status === 'completed')
                                <span class="text-success">
                                    <i class="fas fa-check"></i> Completed {{ $task->time_remaining }}
                                </span>
                            @elseif($task->is_overdue)
                                <span class="text-danger">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $task->time_remaining }}
                                </span>
                            @else
                                <span class="text-info">
                                    <i class="fas fa-clock"></i> Due {{ $task->time_remaining }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($task->description)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Description:</strong>
                            </div>
                            <div class="col-sm-9">
                                <p>{{ $task->description }}</p>
                            </div>
                        </div>
                    @endif

                    @if($task->status === 'completed' && $task->completed_at)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Completed At:</strong>
                            </div>
                            <div class="col-sm-9">
                                <i class="fas fa-check-circle"></i>
                                {{ $task->completed_at->format('M d, Y g:i A') }}
                                <span class="text-muted">({{ $task->completed_at->diffForHumans() }})</span>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $task->created_at->format('M d, Y g:i A') }}
                            <span class="text-muted">({{ $task->created_at->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('workspaces.tasks.edit', [$workspace, $task]) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Task
                    </a>
                    <form method="POST" action="{{ route('workspaces.tasks.destroy', [$workspace, $task]) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this task?')">
                            <i class="fas fa-trash"></i> Delete Task
                        </button>
                    </form>
                    <a href="{{ route('workspaces.tasks.index', $workspace) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Tasks
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Task Progress</h3>
                </div>
                <div class="card-body">
                    @if($task->status === 'completed')
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%">
                                100% Complete
                            </div>
                        </div>
                        <p class="text-success">
                            <i class="fas fa-check-circle"></i> This task has been completed!
                        </p>
                    @else
                        <div class="progress mb-3">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 0%">
                                0% Complete
                            </div>
                        </div>
                        <p class="text-muted">
                            <i class="fas fa-hourglass-half"></i> This task is still pending completion.
                        </p>
                    @endif

                    <hr>

                    <div class="text-center">
                        @if($task->is_overdue && $task->status === 'incomplete')
                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-2"></i>
                            <p class="text-danger"><strong>Task is Overdue!</strong></p>
                        @elseif($task->status === 'completed')
                            <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                            <p class="text-success"><strong>Task Completed!</strong></p>
                        @else
                            <i class="fas fa-clock fa-3x text-info mb-2"></i>
                            <p class="text-info"><strong>Task Pending</strong></p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Workspace Info</h3>
                </div>
                <div class="card-body">
                    <strong>Workspace:</strong>
                    <p><a href="{{ route('workspaces.show', $workspace) }}">{{ $workspace->name }}</a></p>

                    <strong>Total Tasks:</strong>
                    <p>{{ $workspace->tasks->count() }} tasks</p>

                    <strong>Completed:</strong>
                    <p>{{ $workspace->tasks->where('status', 'completed')->count() }} tasks</p>
                </div>
            </div>
        </div>
    </div>
@endsection