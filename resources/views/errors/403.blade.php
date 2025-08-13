@extends('layouts.admin')

@section('page-title', 'Access Denied')

@section('breadcrumb')
    <li class="breadcrumb-item active">403 - Access Denied</li>
@endsection

@section('content')
    <div class="error-page">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Access Denied
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <h1 class="display-1 text-danger">403</h1>
                        <h4 class="mb-4">Oops! You don't have permission to access this resource.</h4>
                        <p class="text-muted mb-4">
                            @if(!empty($exception) && $exception->getMessage())
                                {{ $exception->getMessage() }}
                            @else
                                You don't have the necessary permissions to view this page. This might be because:
                            @endif
                        </p>
                        
                        @if(empty($exception) || empty($exception->getMessage()))
                            <div class="alert alert-info text-left">
                                <ul class="mb-0">
                                    <li>You're trying to access someone else's workspace or tasks</li>
                                    <li>You don't have the required permissions for this action</li>
                                    <li>Your session may have expired</li>
                                </ul>
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary mr-2">
                                <i class="fas fa-home"></i> Go to Dashboard
                            </a>
                            <a href="{{ route('workspaces.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-folder"></i> My Workspaces
                            </a>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Go Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection