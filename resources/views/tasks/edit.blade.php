@extends('layouts.admin')

@section('page-title', 'Edit Task')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('workspaces.index') }}">Workspaces</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.show', $workspace) }}">{{ $workspace->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.tasks.index', $workspace) }}">Tasks</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}">{{ $task->title }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Edit Task: {{ $task->title }}
                    </h3>
                </div>
                <form method="POST" action="{{ route('workspaces.tasks.update', [$workspace, $task]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Task Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $task->title) }}" 
                                   placeholder="Enter task title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter task description (optional)">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deadline_date">Deadline Date <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('deadline') is-invalid @enderror" 
                                           id="deadline_date" 
                                           name="deadline_date" 
                                           value="{{ old('deadline_date', $task->deadline->format('Y-m-d')) }}" 
                                           min="{{ now()->format('Y-m-d') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deadline_time">Deadline Time <span class="text-danger">*</span></label>
                                    <input type="time" 
                                           class="form-control @error('deadline') is-invalid @enderror" 
                                           id="deadline_time" 
                                           name="deadline_time" 
                                           value="{{ old('deadline_time', $task->deadline->format('H:i')) }}" 
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="deadline" id="deadline">
                        
                        @error('deadline')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Current Status:</strong> {!! $task->status_badge !!}
                                @if($task->status === 'completed')
                                    <br><small>Completed {{ $task->completed_at->diffForHumans() }}</small>
                                @else
                                    <br><small>{{ $task->time_remaining }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Task
                        </button>
                        <a href="{{ route('workspaces.tasks.show', [$workspace, $task]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('deadline_date');
    const timeInput = document.getElementById('deadline_time');
    const hiddenInput = document.getElementById('deadline');
    
    function updateDeadline() {
        if (dateInput.value && timeInput.value) {
            const datetime = dateInput.value + ' ' + timeInput.value + ':00';
            hiddenInput.value = datetime;
        }
    }
    
    dateInput.addEventListener('change', updateDeadline);
    timeInput.addEventListener('change', updateDeadline);
    
    // Set initial value
    updateDeadline();
});
</script>
@endpush