@extends('layouts.admin')

@section('page-title', 'Tasks in ' . $workspace->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('workspaces.index') }}">Workspaces</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.show', $workspace) }}">{{ $workspace->name }}</a></li>
    <li class="breadcrumb-item active">Tasks</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks"></i> Tasks in "{{ $workspace->name }}"
                    </h3>
                    <div class="card-tools">
                        @can('create', [App\Models\Task::class, $workspace])
                            <a href="{{ route('workspaces.tasks.create', $workspace) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Task
                            </a>
                        @endcan
                        @can('view', $workspace)
                            <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Workspace
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    @if($tasks->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No tasks in this workspace yet</h4>
                            <p class="text-muted">Add your first task to get started with organizing your work.</p>
                            <a href="{{ route('workspaces.tasks.create', $workspace) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Your First Task
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" class="select-all">
                                        </th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Deadline</th>
                                        <th>Time Remaining</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                                            <td data-label="Select">
                                                <input type="checkbox" class="task-checkbox" value="{{ $task->id }}">
                                            </td>
                                            <td data-label="Title">
                                                <a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}" class="font-weight-bold">
                                                    {{ $task->title }}
                                                </a>
                                                @if($task->description)
                                                    <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td data-label="Status">
                                                {!! $task->status_badge !!}
                                            </td>
                                            <td data-label="Deadline">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar text-muted mr-2"></i>
                                                    <div>
                                                        <strong>{{ $task->deadline->format('M d, Y') }}</strong>
                                                        <br><small class="text-muted">
                                                            <i class="fas fa-clock"></i> {{ $task->deadline->format('g:i A') }}
                                                            <span class="ml-1">({{ $task->deadline->diffForHumans() }})</span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Time Remaining">
                                                @if($task->status === 'completed')
                                                    <div class="d-flex align-items-center text-success">
                                                        <i class="fas fa-check-circle mr-2"></i>
                                                        <div>
                                                            <strong>Completed</strong>
                                                            <br><small>{{ $task->time_remaining }}</small>
                                                        </div>
                                                    </div>
                                                @elseif($task->is_overdue)
                                                    <div class="d-flex align-items-center text-danger">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                                        <div>
                                                            <strong>Overdue</strong>
                                                            <br><small>{{ $task->time_remaining }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex align-items-center text-primary">
                                                        <i class="fas fa-hourglass-half mr-2"></i>
                                                        <div>
                                                            <strong>{{ $task->time_remaining }}</strong>
                                                            <br><small class="text-muted">remaining</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td data-label="Actions">
                                                <div class="btn-group" role="group">
                                                    <form method="POST" action="{{ route('workspaces.tasks.toggle', [$workspace, $task]) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-{{ $task->status === 'completed' ? 'warning' : 'success' }} btn-sm" title="{{ $task->status === 'completed' ? 'Mark as Incomplete' : 'Mark as Complete' }}">
                                                            <i class="fas fa-{{ $task->status === 'completed' ? 'undo' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}" class="btn btn-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('workspaces.tasks.edit', [$workspace, $task]) }}" class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('workspaces.tasks.destroy', [$workspace, $task]) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this task?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                @if($tasks->hasPages())
                    <div class="card-footer">
                        {{ $tasks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection