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
                        <a href="{{ route('workspaces.tasks.create', $workspace) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Task
                        </a>
                        <a href="{{ route('workspaces.show', $workspace) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Workspace
                        </a>
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
                                            <td>
                                                <input type="checkbox" class="task-checkbox" value="{{ $task->id }}">
                                            </td>
                                            <td>
                                                <a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}" class="font-weight-bold">
                                                    {{ $task->title }}
                                                </a>
                                                @if($task->description)
                                                    <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {!! $task->status_badge !!}
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar"></i>
                                                {{ $task->deadline->format('M d, Y') }}
                                                <br><small class="text-muted">{{ $task->deadline->format('g:i A') }}</small>
                                            </td>
                                            <td>
                                                @if($task->status === 'completed')
                                                    <span class="text-success">
                                                        <i class="fas fa-check"></i> {{ $task->time_remaining }}
                                                    </span>
                                                @elseif($task->is_overdue)
                                                    <span class="text-danger">
                                                        <i class="fas fa-exclamation-triangle"></i> {{ $task->time_remaining }}
                                                    </span>
                                                @else
                                                    <span class="text-info">
                                                        <i class="fas fa-clock"></i> {{ $task->time_remaining }}
                                                    </span>
                                                @endif
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