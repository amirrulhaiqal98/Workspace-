<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand/Profile Area -->
    <div class="brand-link d-flex align-items-center justify-content-center px-3" style="background-color: #343a40; min-height: 57px;">
        <!-- Collapsed View (Mini Sidebar) -->
        <div class="sidebar-mini-view d-none">
            <a href="{{ route(name: 'profile.edit') }}" class="d-block">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                         alt="Profile Picture" 
                         class="img-circle elevation-2" 
                         style="width: 35px; height: 35px; object-fit: cover;">
                @else
                    <div class="img-circle elevation-2 bg-primary d-flex align-items-center justify-content-center" 
                         style="width: 35px; height: 35px;">
                        <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                    </div>
                @endif
            </a>
        </div>
        
        <!-- Expanded View (Full Sidebar) -->
        <div class="sidebar-expanded-view d-flex flex-column align-items-center py-3">
            <!-- System Title -->
            <div class="text-light text-center mb-2">
                <h5 class="mb-0 font-weight-bold">WorkSpace</h5>
            </div>
            
            <!-- User Name -->
            <div class="text-light text-center mb-2">
                <small class="font-weight-bold">{{ auth()->user()->name }}</small>
            </div>
            
            <!-- Profile Picture -->
            <div class="profile-picture-container">
                <a href="{{ route('profile.edit') }}" class="d-block">
                    <div class="profile-picture" style="width: 80px; height: 80px; position: relative;">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 alt="Profile Picture" 
                                 class="img-circle elevation-3" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="img-circle elevation-3 bg-primary d-flex align-items-center justify-content-center" 
                                 style="width: 100%; height: 100%;">
                                <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        
                        <!-- Edit Icon Overlay -->
                        <div class="profile-edit-overlay" 
                             style="position: absolute; bottom: 0; right: 0; background: #007bff; 
                                    border-radius: 50%; width: 24px; height: 24px; 
                                    display: flex; align-items: center; justify-content: center;
                                    border: 2px solid white;">
                            <i class="fas fa-camera text-white" style="font-size: 10px;"></i>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Optional: Username -->
            <div class="text-light text-center mt-2">
                <small class="text-muted">&#64;{{ auth()->user()->username }}</small>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">

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