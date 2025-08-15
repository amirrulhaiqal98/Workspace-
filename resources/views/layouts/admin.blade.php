<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    
    <!-- Custom Loading Styles - v2.0 -->
    <style>
        .loading-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            justify-content: center !important;
            align-items: center !important;
            z-index: 9999 !important;
            display: none !important;
        }
        
        /* Force hide when needed */
        #globalLoadingOverlay {
            display: none !important;
        }
        
        /* Only show when explicitly enabled (which is disabled) */
        #globalLoadingOverlay.show {
            display: flex !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .loading-content {
            background: white;
            padding: 30px 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 350px;
            min-width: 300px;
            animation: scaleIn 0.3s ease-out;
            border: 2px solid #007bff;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .loading-spinner {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 10px;
        }
        
        .progress-bar-animated {
            animation: progress-bar-stripes 1s linear infinite;
        }
        
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .table-loading {
            position: relative;
        }
        
        .table-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
            }
            
            /* Fix sidebar for mobile - use AdminLTE's built-in classes */
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
            body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
                margin-left: 0;
            }
            
            .main-sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s ease-in-out;
            }
            
            body.sidebar-open .main-sidebar {
                margin-left: 0;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .table-responsive {
                border: none;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn-group .btn {
                margin-bottom: 5px;
                border-radius: 4px !important;
            }
            
            .info-box {
                margin-bottom: 15px;
            }
            
            .small-box .inner h3 {
                font-size: 2rem;
            }
            
            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }
            
            .loading-content {
                max-width: 280px;
                min-width: 220px;
                padding: 20px 25px;
                margin: 20px;
            }
            
            .timeline {
                padding-left: 30px;
            }
            
            .timeline-item {
                margin-left: -15px;
            }
        }
        
        @media (max-width: 576px) {
            .content-header h1 {
                font-size: 1.5rem;
            }
            
            .breadcrumb {
                background: transparent;
                padding: 0;
                margin: 0;
            }
            
            .btn-group-vertical .btn {
                margin-bottom: 10px;
            }
            
            .card-header .card-tools {
                margin-top: 10px;
            }
            
            .table th, .table td {
                padding: 8px;
                font-size: 0.875rem;
            }
            
            .d-flex.align-items-center {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .loading-content {
                padding: 15px 20px;
                margin: 15px;
                max-width: 250px;
                min-width: 200px;
            }
        }
        
        /* Enhanced mobile table handling */
        @media (max-width: 768px) {
            .table-responsive table,
            .table-responsive thead,
            .table-responsive tbody,
            .table-responsive th,
            .table-responsive td,
            .table-responsive tr {
                display: block;
            }
            
            .table-responsive thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            
            .table-responsive tr {
                border: 1px solid #ddd;
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 8px;
                background: white;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            
            .table-responsive td {
                border: none;
                position: relative;
                padding: 8px 8px 8px 50%;
                text-align: right;
                min-height: 40px;
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }
            
            .table-responsive td:before {
                content: attr(data-label) ":";
                position: absolute;
                left: 8px;
                width: 45%;
                text-align: left;
                font-weight: bold;
                white-space: nowrap;
                color: #495057;
                display: flex;
                align-items: center;
            }
            
            .table-responsive td:first-child {
                background-color: #f8f9fa;
                border-radius: 6px 6px 0 0;
                font-weight: bold;
            }
            
            .table-responsive td:last-child {
                border-radius: 0 0 6px 6px;
                background-color: #ffffff;
            }
        }
        
        /* Mobile button improvements */
        @media (max-width: 576px) {
            .btn-group .btn {
                font-size: 14px;
                padding: 8px 12px;
            }
            
            .card-tools .btn-group {
                flex-direction: column;
            }
            
            .card-tools .btn-group .btn {
                margin-bottom: 5px;
                border-radius: 4px !important;
            }
            
            .small-box .inner h3 {
                font-size: 1.8rem;
            }
            
            .small-box .inner p {
                font-size: 14px;
            }
        }
        
        /* Responsive input groups */
        @media (max-width: 576px) {
            .input-group-prepend {
                display: none;
            }
            
            .form-control {
                border-radius: 4px !important;
            }
            
            .btn-block {
                width: 100%;
                margin-bottom: 10px;
            }
        }
        
        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: block;
        }
        
        /* Mobile sidebar improvements */
        @media (max-width: 768px) {
            .main-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 1050;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
            }
            
            body.sidebar-open .main-sidebar {
                margin-left: 0;
            }
            
            /* Ensure content doesn't get covered */
            .content-wrapper {
                min-height: calc(100vh - 57px);
            }
        }
        
        /* Sidebar collapse handling for profile picture */
        .sidebar-mini .main-sidebar .sidebar-mini-view {
            display: block !important;
        }
        
        .sidebar-mini .main-sidebar .sidebar-expanded-view {
            display: none !important;
        }
        
        .sidebar-mini .main-sidebar .brand-link {
            padding: 0.5rem !important;
        }
        
        body:not(.sidebar-mini) .sidebar-mini-view {
            display: none !important;
        }
        
        body:not(.sidebar-mini) .sidebar-expanded-view {
            display: block !important;
        }
        
        /* Mobile responsive navbar profile picture */
        @media (max-width: 576px) {
            .navbar .user-image {
                margin-right: 0.5rem !important;
            }
            
            .navbar .user-image img,
            .navbar .user-image .img-circle {
                width: 28px !important;
                height: 28px !important;
            }
            
            .navbar .user-image .fas {
                font-size: 12px !important;
            }
            
            .dropdown-menu-lg {
                max-width: calc(100vw - 20px) !important;
                left: auto !important;
                right: 10px !important;
            }
            
            .dropdown-header .img-circle {
                width: 35px !important;
                height: 35px !important;
            }
            
            .dropdown-header .fas {
                font-size: 14px !important;
            }
        }
        
        @media (max-width: 320px) {
            .navbar .user-image img,
            .navbar .user-image .img-circle {
                width: 24px !important;
                height: 24px !important;
            }
            
            .navbar .user-image .fas {
                font-size: 10px !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Main Sidebar Container -->
        @include('partials.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Warning!</strong> {{ session('warning') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Info:</strong> {{ session('info') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Global Loading Overlay -->
        <div class="loading-overlay" id="globalLoadingOverlay" style="display: none;">
            <div class="loading-content">
                <!-- Close Button -->
                <button type="button" class="close" style="position: absolute; top: 10px; right: 15px; font-size: 1.5rem; color: #007bff;" onclick="hideGlobalLoading();">
                    <span>&times;</span>
                </button>
                
                <div class="loading-spinner">
                    <i class="fas fa-cog fa-spin" style="font-size: 3rem; color: #007bff;"></i>
                </div>
                <h4 class="mt-3 mb-2" style="color: #007bff;">Processing Request</h4>
                <p class="text-muted mb-3">Please wait while we process your request...</p>
                <div class="progress" style="height: 6px; border-radius: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                         role="progressbar" style="width: 100%; border-radius: 10px;"></div>
                </div>
                <small class="text-muted mt-2 d-block">Click anywhere to close this popup</small>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">
                            <i class="fas fa-exclamation-triangle text-warning"></i> Confirm Action
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="confirmModalBody">
                        Are you sure you want to continue?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger" id="confirmModalConfirm">
                            <i class="fas fa-check"></i> Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Modal -->
        <div class="modal fade" id="quickActionModal" tabindex="-1" role="dialog" aria-labelledby="quickActionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quickActionModalLabel">
                            <i class="fas fa-bolt text-primary"></i> Quick Actions
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="quickActionModalBody">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6><i class="fas fa-folder"></i> Workspace Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('workspaces.create') }}" class="btn btn-primary btn-block btn-sm mb-2">
                                            <i class="fas fa-plus"></i> Create Workspace
                                        </a>
                                        <a href="{{ route('workspaces.index') }}" class="btn btn-info btn-block btn-sm">
                                            <i class="fas fa-list"></i> View All Workspaces
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6><i class="fas fa-user"></i> Account Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-block btn-sm mb-2">
                                            <i class="fas fa-user-edit"></i> Edit Profile
                                        </a>
                                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('partials.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    
    <!-- Auto-dismiss alerts after 5 seconds -->
    <script>
        $(document).ready(function() {
            // EMERGENCY: Force hide any stuck loading overlays on page load
            $('#globalLoadingOverlay').hide().fadeOut(0);
            $('.loading-overlay').hide().fadeOut(0);
            
            // Clean up any stuck button states
            $('.btn-loading').removeClass('btn-loading').prop('disabled', false);
            
            // Add click to close popup if stuck
            $('#globalLoadingOverlay').on('click', function() {
                $(this).hide().fadeOut(0);
            });
            
            // Auto-dismiss success alerts after 5 seconds
            $('.alert-success').delay(5000).fadeOut('slow');
            
            // Auto-dismiss info alerts after 7 seconds
            $('.alert-info').delay(7000).fadeOut('slow');
            
            // Auto-dismiss warning alerts after 8 seconds  
            $('.alert-warning').delay(8000).fadeOut('slow');
            
            // Error alerts stay until manually dismissed
            
            // Global loading functions - DISABLED TO PREVENT STUCK POPUP
            window.showGlobalLoading = function() {
                // DISABLED: $('#globalLoadingOverlay').fadeIn(300);
                console.log('showGlobalLoading called but disabled to prevent stuck popup');
            };
            
            window.hideGlobalLoading = function() {
                // Multiple aggressive methods to hide the popup
                $('#globalLoadingOverlay').removeClass('show').hide().fadeOut(0).css('display', 'none !important');
                $('.loading-overlay').removeClass('show').hide().fadeOut(0).css('display', 'none !important');
                
                // Remove any inline styles that might be keeping it visible
                $('#globalLoadingOverlay').removeAttr('style').css({
                    'display': 'none',
                    'visibility': 'hidden',
                    'opacity': '0'
                });
                
                console.log('Force hiding loading overlay');
            };
            
            // Add loading state to buttons only (no automatic popup)
            $('form').on('submit', function(e) {
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const originalText = submitBtn.html();
                const loadingText = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                
                // Only show button loading, no global popup
                submitBtn.html(loadingText).prop('disabled', true).addClass('btn-loading');
                
                // Store original state for cleanup
                form.data('original-btn-text', originalText);
                form.data('submit-btn', submitBtn);
                
                // Shorter timeout for button only
                const timeoutId = setTimeout(function() {
                    submitBtn.html(originalText).prop('disabled', false).removeClass('btn-loading');
                    console.log('Button state reset after timeout');
                }, 5000);
                
                // Store timeout ID for potential cancellation
                form.data('timeout-id', timeoutId);
            });
            
            // Enhanced confirmation modal for delete actions
            $(document).on('click', '.btn-danger[onclick*="confirm"]', function(e) {
                e.preventDefault();
                const btn = $(this);
                const confirmMessage = btn.attr('onclick').match(/'([^']+)'/)[1];
                
                // Show confirmation modal instead of browser confirm
                $('#confirmModalBody').html('<p><i class="fas fa-exclamation-triangle text-danger"></i> ' + confirmMessage + '</p>');
                $('#confirmModal').modal('show');
                
                // Handle confirmation
                $('#confirmModalConfirm').off('click').on('click', function() {
                    $('#confirmModal').modal('hide');
                    btn.html('<i class="fas fa-spinner fa-spin"></i> Deleting...').prop('disabled', true);
                    
                    // Submit the form without global popup
                    btn.closest('form').off('submit').submit();
                });
            });
            
            // Quick action modal trigger
            $(document).on('keydown', function(e) {
                // Ctrl+K or Cmd+K to open quick actions
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    $('#quickActionModal').modal('show');
                }
            });
            
            // Add progress indicators to navigation links
            $('a[href]').not('.no-loading').on('click', function() {
                const link = $(this);
                const href = link.attr('href');
                
                // Skip external links and anchors
                if (href.startsWith('http') || href.startsWith('#')) {
                    return;
                }
                
                // Show subtle loading for navigation
                const originalText = link.html();
                link.html('<i class="fas fa-spinner fa-pulse"></i> ' + link.text());
                
                setTimeout(function() {
                    link.html(originalText);
                }, 1000);
            });
            
            // Add loading to action buttons (no global popup)
            $('.btn-info, .btn-warning').on('click', function() {
                const btn = $(this);
                const originalText = btn.html();
                
                if (!btn.hasClass('no-loading')) {
                    btn.html('<i class="fas fa-spinner fa-pulse"></i>');
                    setTimeout(function() {
                        btn.html(originalText);
                    }, 800);
                }
            });
            
            // Manual popup trigger - DISABLED
            $('.show-loading-popup').on('click', function() {
                // DISABLED: showGlobalLoading();
                console.log('Manual popup trigger disabled');
            });
            
            // Enhanced mobile sidebar functionality
            function initMobileSidebar() {
                // Handle pushmenu click for mobile
                $('[data-widget="pushmenu"]').on('click', function(e) {
                    e.preventDefault();
                    
                    if ($(window).width() <= 768) {
                        // Mobile behavior
                        $('body').toggleClass('sidebar-open');
                        
                        // Add overlay for mobile
                        if ($('body').hasClass('sidebar-open')) {
                            if (!$('.sidebar-overlay').length) {
                                $('body').append('<div class="sidebar-overlay"></div>');
                            }
                        } else {
                            $('.sidebar-overlay').remove();
                        }
                    }
                });
                
                // Close sidebar when clicking overlay
                $(document).on('click', '.sidebar-overlay', function() {
                    $('body').removeClass('sidebar-open');
                    $(this).remove();
                });
                
                // Close sidebar on window resize if open
                $(window).on('resize', function() {
                    if ($(window).width() > 768) {
                        $('body').removeClass('sidebar-open');
                        $('.sidebar-overlay').remove();
                    }
                });
            }
            
            // Initialize mobile sidebar
            initMobileSidebar();
            
            // EMERGENCY: Run every 2 seconds to force hide any stuck popup
            setInterval(function() {
                if ($('#globalLoadingOverlay').is(':visible')) {
                    console.log('EMERGENCY: Detected visible popup, force hiding...');
                    hideGlobalLoading();
                }
            }, 2000);
            
            // Clean up loading states when navigating away
            $(window).on('beforeunload unload', function() {
                hideGlobalLoading();
                $('.btn-loading').removeClass('btn-loading').prop('disabled', false);
            });
            
            // Handle page visibility change (when user switches tabs/apps)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    // Page became visible again - ensure loading is hidden
                    setTimeout(function() {
                        hideGlobalLoading();
                    }, 100);
                }
            });
            
            // Additional safety net - hide loading after any form submission completes
            $(document).ajaxComplete(function() {
                hideGlobalLoading();
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>