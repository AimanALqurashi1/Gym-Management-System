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
        <a href="{{ route('admin.dashboard') }}"
            class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-page="dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="{{ route('member.index') }}" class="menu-item {{ request()->routeIs('member.*') ? 'active' : '' }}"
            data-page="members">
            <i class="fas fa-users"></i>
            <span class="menu-text">Members</span>
            <span class="menu-badge">5</span>
        </a>

        <a href="{{ route('Course.index') }}" class="menu-item {{ request()->routeIs('Course.*') ? 'active' : '' }}"
            data-page="classes">
            <i class="fas fa-calendar-alt"></i>
            <span class="menu-text">Classes</span>
            <span class="menu-badge">12</span>
        </a>

        <a href="{{ route('attendance.today') }}"
            class="menu-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}" data-page="attendance">
            <i class="fas fa-clipboard-check"></i>
            <span class="menu-text">Attendance</span>
        </a>

        <a href="{{ route('payments.index') }}" class="menu-item {{ request()->routeIs('payments.*') ? 'active' : '' }}"
            data-page="payments">
            <i class="fas fa-credit-card"></i>
            <span class="menu-text">Payments</span>
            <span class="menu-badge">3</span>
        </a>

        <a href="{{ route('cancellation.manage') }}"
            class="menu-item {{ request()->routeIs('cancellation.*') ? 'active' : '' }}" data-page="cancellation">
            <i class="fas fa-history"></i>
            <span class="menu-text">Cancellation</span>

        </a>


        <a href="{{ route('trainer.index') }}" class="menu-item {{ request()->routeIs('trainer.*') ? 'active' : '' }}"
            data-page="trainers">
            <i class="fas fa-user-tie"></i>
            <span class="menu-text">Trainers</span>
        </a>

        <a href="{{ route('equipment.index') }}"
            class="menu-item {{ request()->routeIs('equipment.*') ? 'active' : '' }}" data-page="equipment">
            <i class="fas fa-dumbbell"></i>
            <span class="menu-text">Equipment</span>
        </a>

        <a href="{{ route('reports.index') }}" class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}"
            data-page="reports">
            <i class="fas fa-chart-bar"></i>
            <span class="menu-text">Reports</span>
        </a>


        <a href="{{ route('admin.monitor') }}"
            class="menu-item {{ request()->routeIs('admin.monitor') ? 'active' : '' }}" data-page="monitor">
            <i class="fas fa-users"></i>
            <span class="menu-text">Monitor</span>
            <span class="menu-badge">5</span>
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
