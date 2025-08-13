@extends('layouts.admin')

@section('page-title', 'Create Task')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('workspaces.index') }}">Workspaces</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.show', $workspace) }}">{{ $workspace->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('workspaces.tasks.index', $workspace) }}">Tasks</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i> Create New Task in "{{ $workspace->name }}"
                    </h3>
                </div>
                <form method="POST" action="{{ route('workspaces.tasks.store', $workspace) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Task Title <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                </div>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Enter task title"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                <i class="fas fa-align-left"></i> Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter task description (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Provide additional details about this task (optional)
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deadline_date">
                                        <i class="fas fa-calendar"></i> Deadline Date <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" 
                                               class="form-control @error('deadline') is-invalid @enderror" 
                                               id="deadline_date" 
                                               name="deadline_date" 
                                               value="{{ old('deadline_date', now()->addDay()->format('Y-m-d')) }}" 
                                               min="{{ now()->format('Y-m-d') }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deadline_time">
                                        <i class="fas fa-clock"></i> Deadline Time <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <input type="time" 
                                               class="form-control @error('deadline') is-invalid @enderror" 
                                               id="deadline_time" 
                                               name="deadline_time" 
                                               value="{{ old('deadline_time', '17:00') }}" 
                                               required>
                                    </div>
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
                                <strong>Note:</strong> The deadline must be in the future. Tasks will show time remaining and status based on this deadline.
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Create Task
                        </button>
                        <a href="{{ route('workspaces.tasks.index', $workspace) }}" class="btn btn-secondary">
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