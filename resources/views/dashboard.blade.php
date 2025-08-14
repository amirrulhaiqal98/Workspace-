@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Workspaces</span>
                    <span class="info-box-number">
                        {{ $workspaceCount }}
                        <small class="d-block">Total created</small>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tasks"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Tasks</span>
                    <span class="info-box-number">
                        {{ $totalTasks }}
                        <small class="d-block">Across all workspaces</small>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Completed</span>
                    <span class="info-box-number">
                        {{ $completedTasks }}
                        @if($totalTasks > 0)
                            <small class="d-block">{{ number_format(($completedTasks / $totalTasks) * 100, 1) }}% done</small>
                        @else
                            <small class="d-block">Get started!</small>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">
                        {{ $pendingTasks }}
                        <small class="d-block">Need attention</small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Chart -->
    @if($totalTasks > 0)
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Task Completion Overview
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-responsive">
                            <canvas id="pieChart" height="150"></canvas>
                        </div>
                        <div class="mt-3">
                            <div class="progress-group">
                                Completion Rate
                                <span class="float-right"><b>{{ $completedTasks }}</b>/{{ $totalTasks }}</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" 
                                         style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Productivity Stats
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="progress-group">
                            <span class="progress-text">Workspaces Created</span>
                            <span class="float-right"><b>{{ $workspaceCount }}</b>/{{ config('app.user_max_workspaces', 50) }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-info" 
                                     style="width: {{ ($workspaceCount / config('app.user_max_workspaces', 50)) * 100 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="progress-group">
                            <span class="progress-text">Task Completion Rate</span>
                            <span class="float-right"><b>{{ $totalTasks > 0 ? number_format(($completedTasks / $totalTasks) * 100, 1) : 0 }}%</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="progress-group">
                            <span class="progress-text">Active Tasks</span>
                            <span class="float-right"><b>{{ $pendingTasks }}</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" 
                                     style="width: {{ $totalTasks > 0 ? ($pendingTasks / $totalTasks) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Actions & Welcome Cards -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-circle mr-2"></i>
                        Welcome back, {{ Auth::user()->name }}!
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ now()->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($workspaceCount == 0)
                        <div class="text-center py-4">
                            <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                            <h4>Ready to get started?</h4>
                            <p class="text-muted">Create your first workspace to begin organizing your tasks and boosting productivity!</p>
                            <a href="{{ route('workspaces.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus mr-1"></i> Create Your First Workspace
                            </a>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <h5><i class="fas fa-chart-line text-success"></i> Your Progress</h5>
                                <p>You've created <strong>{{ $workspaceCount }}</strong> workspace{{ $workspaceCount != 1 ? 's' : '' }} 
                                   and completed <strong>{{ $completedTasks }}</strong> out of <strong>{{ $totalTasks }}</strong> tasks.</p>
                                
                                @if($pendingTasks > 0)
                                    <div class="alert alert-warning alert-dismissible">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        You have <strong>{{ $pendingTasks }}</strong> pending task{{ $pendingTasks != 1 ? 's' : '' }} that need attention.
                                        <a href="{{ route('workspaces.index') }}" class="alert-link">View them now</a>
                                    </div>
                                @else
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        Excellent! All your tasks are completed. Time to create new ones!
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="d-flex d-lg-block justify-content-center">
                                    <div class="btn-group btn-group-lg d-lg-none" role="group">
                                        <a href="{{ route('workspaces.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">New Workspace</span>
                                        </a>
                                        <a href="{{ route('workspaces.index') }}" class="btn btn-info">
                                            <i class="fas fa-folder-open"></i> <span class="d-none d-sm-inline">View All</span>
                                        </a>
                                    </div>
                                    <div class="btn-group-vertical d-none d-lg-flex w-100" role="group">
                                        <a href="{{ route('workspaces.create') }}" class="btn btn-primary mb-2">
                                            <i class="fas fa-plus"></i> New Workspace
                                        </a>
                                        <a href="{{ route('workspaces.index') }}" class="btn btn-info mb-2">
                                            <i class="fas fa-folder-open"></i> View Workspaces
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Quick Tips
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-blue">Pro Tips</span>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-yellow"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">Set realistic deadlines</h3>
                                <div class="timeline-body">
                                    Always add buffer time to your task deadlines to account for unexpected delays.
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-folder bg-green"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">Organize with workspaces</h3>
                                <div class="timeline-body">
                                    Group related tasks in separate workspaces for better organization.
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-check bg-blue"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">Track your progress</h3>
                                <div class="timeline-body">
                                    Regularly mark tasks as complete to see your productivity trends.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if($totalTasks > 0)
<script>
$(document).ready(function () {
    // Pie Chart
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieData = {
        labels: [
            'Completed Tasks',
            'Pending Tasks'
        ],
        datasets: [{
            data: [{{ $completedTasks }}, {{ $pendingTasks }}],
            backgroundColor: ['#28a745', '#ffc107'],
            borderColor: ['#1e7e34', '#e0a800'],
            borderWidth: 2
        }]
    };
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    };
    new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    });
});
</script>
@endif
@endpush
