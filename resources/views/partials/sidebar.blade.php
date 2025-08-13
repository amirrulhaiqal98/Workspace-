<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <i class="brand-image fas fa-tasks text-primary" style="font-size: 2rem; margin-left: 10px; margin-right: 5px;"></i>
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary" style="width: 35px; height: 35px;">
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">
                    <i class="fas fa-circle text-success" style="font-size: 8px;"></i> {{ Auth::user()->name }}
                </a>
                <small class="text-muted">@{{ Auth::user()->username }}</small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                        <p>
                            Dashboard
                            <span class="badge badge-info right">Home</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('workspaces.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('workspaces.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder text-warning"></i>
                        <p>
                            Workspaces
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-warning right">{{ Auth::user()->workspaces()->count() }}</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('workspaces.index') }}" class="nav-link {{ request()->routeIs('workspaces.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon text-info"></i>
                                <p>All Workspaces</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('workspaces.create') }}" class="nav-link {{ request()->routeIs('workspaces.create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon text-success"></i>
                                <p>Create Workspace</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog text-secondary"></i>
                        <p>
                            Profile
                            <span class="badge badge-secondary right">Settings</span>
                        </p>
                    </a>
                </li>
                
                <!-- Divider -->
                <li class="nav-header">QUICK STATS</li>
                
                <!-- Quick Stats -->
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-chart-pie text-success"></i>
                        <p>
                            Total Tasks
                            <span class="badge badge-success right">{{ Auth::user()->workspaces()->withCount('tasks')->get()->sum('tasks_count') }}</span>
                        </p>
                    </div>
                </li>
                
                <li class="nav-item">
                    <div class="nav-link">
                        <i class="nav-icon fas fa-check-circle text-primary"></i>
                        <p>
                            Completed
                            <span class="badge badge-primary right">{{ Auth::user()->workspaces()->with(['tasks' => function($query) { $query->where('status', 'completed'); }])->get()->flatMap->tasks->count() }}</span>
                        </p>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</aside>