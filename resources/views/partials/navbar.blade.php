<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Quick Actions Button -->
        <li class="nav-item">
            <button class="btn btn-link nav-link" data-toggle="modal" data-target="#quickActionModal" title="Quick Actions (Ctrl+K)">
                <i class="fas fa-bolt text-primary"></i>
            </button>
        </li>
        
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <div class="user-image mr-2">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 alt="Profile Picture" 
                                 class="img-circle elevation-1" 
                                 style="width: 32px; height: 32px; object-fit: cover;">
                        @else
                            <div class="img-circle d-flex justify-content-center align-items-center bg-primary" style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="user-info d-none d-sm-block">
                        <div class="text-dark font-weight-bold" style="font-size: 14px;">{{ auth()->user()->name }}</div>
                        <div class="text-muted d-none d-md-block" style="font-size: 12px;">&#64;{{ auth()->user()->username }}</div>
                    </div>
                    <i class="fas fa-chevron-down ml-1 ml-sm-2 text-muted" style="font-size: 12px;"></i>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
                <div class="dropdown-header bg-light">
                    <div class="d-flex align-items-center">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 alt="Profile Picture" 
                                 class="img-circle elevation-1 mr-3" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <div class="img-circle bg-primary d-flex justify-content-center align-items-center mr-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        @endif
                        <div>
                            <div class="font-weight-bold">{{ auth()->user()->name }}</div>
                            <div class="text-muted small">&#64;{{ auth()->user()->username }}</div>
                            <div class="text-muted small">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-edit mr-2 text-primary"></i> Edit Profile
                </a>
                <a href="{{ route('workspaces.index') }}" class="dropdown-item">
                    <i class="fas fa-folder mr-2 text-warning"></i> My Workspaces
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-left text-danger w-100 p-3" style="text-decoration: none;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>