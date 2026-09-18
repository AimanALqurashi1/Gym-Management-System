<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" class="logo">
            <i class="fas fa-dumbbell"></i>
            <span class="logo-text">Yangzhou<span>Gym</span></span>
        </a>
        <button class="toggle-btn" id="toggleSidebar">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('member.dashboard') }}"
            class="menu-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}" data-page="dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="{{ route('member.schedule') }}"
            class="menu-item {{ request()->routeIs('member.schedule') ? 'active' : '' }}" data-page="members">
            <i class="fas fa-calendar-alt"></i>
            <span class="menu-text">Schedule</span>
            <span class="menu-badge">5</span>
        </a>

        <a href="{{ route('member.attendance') }}"
            class="menu-item {{ request()->routeIs('member.attendance') ? 'active' : '' }}" data-page="classes">
            <i class="fas fa-clipboard-check"></i>
            <span class="menu-text">Attendance</span>
            <span class="menu-badge">12</span>
        </a>

        <a href="{{ route('member.profile') }}"
            class="menu-item {{ request()->routeIs('member.profile') ? 'active' : '' }}" data-page="attendance">
            <i class="fas fa-user"></i>
            <span class="menu-text">Profile</span>
        </a>



    </div>

    {{-- <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">AJ</div>
            <div class="user-info">
                <h4>{{ Auth::user->name }}</h4>
                <p>{{ Auth::user->role }}</p>
            </div>
            <a href="{{ route('logout') }}" class="menu-item" style="padding: 0; margin-left: auto;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div> --}}

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                @if (Auth::user()->photo && file_exists(public_path('admin/uploads/' . Auth::user()->photo)))
                    <img src="{{ asset('admin/uploads/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}"
                        class="user-avatar">
                @else
                    @if (Auth::user()->gender == 'female')
                        <img src="{{ asset('admin/uploads/femaleLogo.jpg') }}" alt="{{ Auth::user()->name }}"
                            class="user-avatar">
                    @else
                        <img src="{{ asset('admin/uploads/maleLogo.png') }}" alt="{{ Auth::user()->name }}"
                            class="user-avatar">
                    @endif
                @endif
            </div>
            <div class="user-info">
                <h4>{{ Auth::user()->name }}</h4>
                <p>{{ Auth::user()->role ?? 'Administrator' }}</p>
            </div>
            <a href="{{ route('logout') }}" class="menu-item" style="padding: 0; margin-left: auto;"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <!-- Add logout form (required for POST logout) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</aside>
