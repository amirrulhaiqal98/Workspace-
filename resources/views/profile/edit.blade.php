@extends('layouts.admin')

@section('page-title', 'Profile Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <!-- Profile Overview -->
    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="profile-user-img img-circle elevation-2 d-inline-flex align-items-center justify-content-center bg-primary" 
                             style="width: 128px; height: 128px; font-size: 3rem;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    </div>

                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                    <p class="text-muted text-center">@{{ Auth::user()->username }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b><i class="fas fa-envelope mr-1"></i> Email</b>
                            <span class="float-right">{{ Auth::user()->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-folder mr-1"></i> Workspaces</b>
                            <span class="float-right">{{ Auth::user()->workspaces()->count() }}</span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-tasks mr-1"></i> Total Tasks</b>
                            <span class="float-right">{{ Auth::user()->workspaces()->withCount('tasks')->get()->sum('tasks_count') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-calendar mr-1"></i> Member Since</b>
                            <span class="float-right">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </li>
                    </ul>

                    <div class="text-center">
                        <span class="badge badge-success">Active Account</span>
                        @if(Auth::user()->email_verified_at)
                            <span class="badge badge-info">Verified</span>
                        @else
                            <span class="badge badge-warning">Unverified</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock mr-1"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        <div class="time-label">
                            <span class="bg-success">
                                Account Created
                            </span>
                        </div>
                        <div>
                            <i class="fas fa-user bg-primary"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> {{ Auth::user()->created_at->diffForHumans() }}</span>
                                <h3 class="timeline-header">Account Registration</h3>
                                <div class="timeline-body">
                                    Your account was successfully created and you joined the task management system.
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="profile-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-info-tab" data-toggle="pill" href="#profile-info" role="tab">
                                <i class="fas fa-user mr-1"></i> Profile Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab">
                                <i class="fas fa-lock mr-1"></i> Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="danger-tab" data-toggle="pill" href="#danger" role="tab">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Danger Zone
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="profile-tabsContent">
                        <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            @include('profile.partials.update-password-form')
                        </div>
                        <div class="tab-pane fade" id="danger" role="tabpanel">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle tab switching with proper URL updates
    $('#profile-tabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        
        // Update URL without refreshing page
        const tabId = $(this).attr('href').substring(1);
        window.history.pushState({}, '', window.location.pathname + '#' + tabId);
    });
    
    // Activate tab based on URL hash
    if (window.location.hash) {
        $('#profile-tabs a[href="' + window.location.hash + '"]').tab('show');
    }
});
</script>
@endpush
