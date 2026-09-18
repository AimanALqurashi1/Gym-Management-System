{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.home')

@section('title', 'Monitor')

@section('css')
    <style>
        /* Admin Container - Light Theme */
        .admin-container {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: var(--dark);
            font-size: 2.2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header h1 i {
            color: var(--primary);
        }

        /* Stats Cards - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.users {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon.members {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.trainers {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
        }

        .stat-icon.classes {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-icon.equipment {
            background: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .stat-icon.attendance {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 2rem;
            margin: 0;
            font-weight: 700;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
            font-weight: 500;
        }

        /* Quick Actions - Light Theme */
        .quick-actions {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .quick-actions h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
        }

        .quick-actions h3 i {
            color: var(--primary);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .action-btn {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 12px 25px;
            color: var(--dark);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            font-weight: 600;
        }

        .action-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .action-btn i {
            color: var(--primary);
        }

        .action-btn:hover i {
            color: white;
        }

        .btn-logout {
            background: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.3);
        }

        .btn-logout i {
            color: var(--danger);
        }

        .btn-logout:hover {
            background: var(--danger);
            border-color: var(--danger);
        }

        .btn-logout:hover i {
            color: white;
        }

        /* Dashboard Grid - Light Theme */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Cards - Light Theme */
        .dashboard-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .dashboard-card:hover {
            border-color: var(--border-primary);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, white, #fafafa);
        }

        .card-header h3 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .card-header h3 i {
            color: var(--primary);
        }

        .card-header .badge {
            background: var(--primary-light);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        /* Tables - Light Theme */
        .table-responsive {
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            padding: 12px;
            color: var(--gray);
            font-weight: 700;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-table td {
            padding: 12px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr {
            transition: var(--transition);
        }

        .admin-table tbody tr:hover {
            background: var(--primary-light);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
        }

        .user-email {
            font-size: 0.75rem;
            color: var(--gray);
        }

        /* Badges - Light Theme */
        .badge-role {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin {
            background: rgba(255, 85, 0, 0.15);
            color: var(--primary);
            border: 1px solid var(--border-primary);
        }

        .role-trainer {
            background: rgba(0, 168, 255, 0.15);
            color: var(--accent);
            border: 1px solid rgba(0, 168, 255, 0.2);
        }

        .role-member {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .role-user {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-suspended {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .btn-icon {
            background: transparent;
            border: none;
            color: var(--gray);
            padding: 5px 10px;
            border-radius: 5px;
            transition: var(--transition);
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1);
        }

        /* Activity List - Light Theme */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .activity-item:hover {
            background: var(--primary-light);
            padding-left: 10px;
            margin-left: -10px;
            border-radius: 8px;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon.success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .activity-icon.primary {
            background: var(--primary-light);
            color: var(--primary);
        }

        .activity-icon.warning {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .activity-details {
            flex: 1;
        }

        .activity-title {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 0.9rem;
        }

        .activity-time {
            color: var(--gray);
            font-size: 0.75rem;
        }

        /* Health Cards - Light Theme */
        .health-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .health-card {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: var(--transition);
        }

        .health-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            background: white;
        }

        .health-value {
            color: var(--dark);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .health-label {
            color: var(--gray);
            font-size: 0.8rem;
            margin-top: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .health-warning {
            color: var(--warning);
        }

        .health-danger {
            color: var(--danger);
        }

        /* View All Link */
        .view-all {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .view-all a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .view-all a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .admin-container {
                padding: 20px;
            }
        }

        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .health-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .health-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-grid {
                gap: 20px;
            }

            .card-header {
                padding: 15px;
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .admin-container {
                padding: 10px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 15px;
            }

            .admin-table th,
            .admin-table td {
                padding: 8px;
                font-size: 0.8rem;
            }

            .user-avatar {
                width: 30px;
                height: 30px;
            }
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .dashboard-card,
        .quick-actions {
            animation: slideInUp 0.4s ease forwards;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray-light);
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="admin-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-crown"></i>
                Admin Monitor
            </h1>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                    <small style="color: var(--gray-light);">{{ $newUsersToday }} new today</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon members">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalMembers }}</h3>
                    <p>Active Members</p>
                    <small style="color: var(--gray-light);">{{ $newMembersToday }} joined today</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon trainers">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalTrainers }}</h3>
                    <p>Trainers</p>
                    <small style="color: var(--gray-light);">{{ $activeTrainers }} active now</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon classes">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $todayClasses }}</h3>
                    <p>Classes Today</p>
                    <small style="color: var(--gray-light);">{{ $weekClasses }} this week</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon equipment">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalEquipment }}</h3>
                    <p>Equipment</p>
                    <small style="color: var(--gray-light);">{{ $equipmentInUse }} in use</small>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon attendance">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalAttendance }}</h3>
                    <p>Check-ins Today</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
            <div class="action-buttons">
                <a href="{{ route('admin.users.index') }}" class="action-btn">
                    <i class="fas fa-users-cog"></i>
                    Manage Users
                </a>
                <a href="{{ route('admin.users.create') }}" class="action-btn">
                    <i class="fas fa-user-plus"></i>
                    Add New User
                </a>
                <a href="{{ route('reports.index') }}" class="action-btn">
                    <i class="fas fa-chart-bar"></i>
                    Generate Report
                </a>
                <a href="{{ route('equipment.index') }}" class="action-btn">
                    <i class="fas fa-tools"></i>
                    Manage Equipment
                </a>
                <a href="{{ route('attendance.today') }}" class="action-btn">
                    <i class="fas fa-clipboard-list"></i>
                    Today's Attendance
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Recent Users -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-user-clock"></i> Recent Users</h3>
                    <span class="badge">{{ $recentUsers->count() }} new</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar">
                                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}">
                                                </div>
                                                <span>{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span
                                                class="badge-role {{ $user->role === 'admin' ? 'role-admin' : 'role-user' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge {{ $user->status === 'active' ? 'status-active' : 'status-suspended' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 15px; text-align: right;">
                        <a href="{{ route('admin.users.index') }}" style="color: var(--primary); text-decoration: none;">
                            View All Users <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i> Recent Activities</h3>
                </div>
                <div class="card-body">
                    <ul class="activity-list">
                        @forelse($recentActivities as $activity)
                            <li class="activity-item">
                                <div class="activity-icon {{ $activity['color'] }}">
                                    <i class="fas fa-{{ $activity['icon'] }}"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">{{ $activity['description'] }}</div>
                                    <div class="activity-time">{{ $activity['time'] }}</div>
                                </div>
                            </li>
                        @empty
                            <li style="color: var(--gray-light); text-align: center; padding: 20px;">
                                <i class="fas fa-info-circle"></i> No recent activities
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Today's Classes -->
        <div class="dashboard-card" style="margin-bottom: 30px;">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Today's Classes</h3>
                <span class="badge">{{ $todaysClasses->count() }} classes</span>
            </div>
            <div class="card-body">
                @if ($todaysClasses->count() > 0)
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Course</th>
                                    <th>Trainer</th>
                                    <th>Enrolled</th>
                                    <th>Present</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todaysClasses as $class)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}</td>
                                        <td>{{ $class->course->name ?? 'N/A' }}</td>
                                        <td>{{ $class->trainer->name ?? 'N/A' }}</td>
                                        <td>{{ $class->enrolled }}/{{ $class->total_spots }}</td>
                                        <td>{{ $class->present }}</td>
                                        <td>
                                            @if ($class->enrolled == 0)
                                                <span class="status-badge"
                                                    style="background: rgba(108, 117, 125, 0.15); color: var(--gray-light);">No
                                                    enrollments</span>
                                            @elseif($class->present == 0)
                                                <span class="status-badge status-suspended">No check-ins</span>
                                            @else
                                                <span
                                                    class="status-badge status-active">{{ round(($class->present / $class->enrolled) * 100) }}%
                                                    present</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('attendance.class', $class->id) }}" class="btn-icon"
                                                title="Mark Attendance">
                                                <i class="fas fa-clipboard-check"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 20px;">
                        <i class="fas fa-calendar-times"></i> No classes scheduled for today
                    </p>
                @endif
            </div>
        </div>

        <!-- System Health -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-heartbeat"></i> System Health</h3>
            </div>
            <div class="card-body">
                <div class="health-grid">
                    <div class="health-card">
                        <div class="health-value {{ $systemHealth['pending_maintenance'] > 0 ? 'health-warning' : '' }}">
                            {{ $systemHealth['pending_maintenance'] }}
                        </div>
                        <div class="health-label">Pending Maintenance</div>
                    </div>
                    <div class="health-card">
                        <div
                            class="health-value {{ $systemHealth['classes_with_low_attendance'] > 0 ? 'health-warning' : '' }}">
                            {{ $systemHealth['classes_with_low_attendance'] }}
                        </div>
                        <div class="health-label">Low Attendance Classes</div>
                    </div>
                    <div class="health-card">
                        <div class="health-value {{ $systemHealth['expiring_this_week'] > 0 ? 'health-warning' : '' }}">
                            {{ $systemHealth['expiring_this_week'] }}
                        </div>
                        <div class="health-label">Expiring Memberships</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
