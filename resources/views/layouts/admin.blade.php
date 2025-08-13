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
    
    <!-- Custom Loading Styles -->
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        
        .loading-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .loading-spinner {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 15px;
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
            
            .main-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .main-sidebar.sidebar-open {
                transform: translateX(0);
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
                padding: 20px;
                margin: 20px;
            }
        }
        
        /* Improved mobile table handling */
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
                border: 1px solid #ccc;
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 5px;
                background: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .table-responsive td {
                border: none;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }
            
            .table-responsive td:before {
                content: attr(data-label) ":";
                position: absolute;
                left: 6px;
                width: 45%;
                text-align: left;
                font-weight: bold;
                white-space: nowrap;
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
        <div class="loading-overlay" id="globalLoadingOverlay">
            <div class="loading-content">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h4>Processing...</h4>
                <p class="text-muted">Please wait while we process your request.</p>
                <div class="progress mt-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                         role="progressbar" style="width: 100%"></div>
                </div>
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
            <div class="modal-dialog modal-lg" role="document">
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
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6><i class="fas fa-folder"></i> Workspace Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('workspaces.create') }}" class="btn btn-primary btn-block mb-2">
                                            <i class="fas fa-plus"></i> Create Workspace
                                        </a>
                                        <a href="{{ route('workspaces.index') }}" class="btn btn-info btn-block">
                                            <i class="fas fa-list"></i> View All Workspaces
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6><i class="fas fa-user"></i> Account Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-block mb-2">
                                            <i class="fas fa-user-edit"></i> Edit Profile
                                        </a>
                                        <button type="button" class="btn btn-danger btn-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            // Auto-dismiss success alerts after 5 seconds
            $('.alert-success').delay(5000).fadeOut('slow');
            
            // Auto-dismiss info alerts after 7 seconds
            $('.alert-info').delay(7000).fadeOut('slow');
            
            // Auto-dismiss warning alerts after 8 seconds  
            $('.alert-warning').delay(8000).fadeOut('slow');
            
            // Error alerts stay until manually dismissed
            
            // Global loading functions
            window.showGlobalLoading = function() {
                $('#globalLoadingOverlay').fadeIn(300);
            };
            
            window.hideGlobalLoading = function() {
                $('#globalLoadingOverlay').fadeOut(300);
            };
            
            // Add loading state to all forms
            $('form').on('submit', function() {
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const originalText = submitBtn.html();
                const loadingText = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                
                // Show global loading for longer operations
                showGlobalLoading();
                
                // Disable button and show loading
                submitBtn.html(loadingText).prop('disabled', true).addClass('btn-loading');
                
                // Re-enable after 5 seconds as fallback
                setTimeout(function() {
                    submitBtn.html(originalText).prop('disabled', false).removeClass('btn-loading');
                    hideGlobalLoading();
                }, 5000);
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
                    showGlobalLoading();
                    
                    // Submit the form
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
            
            // Add loading to action buttons
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
        });
    </script>
    
    @stack('scripts')
</body>
</html>