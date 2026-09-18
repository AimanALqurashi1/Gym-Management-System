{{-- resources/views/member/dashboard.blade.php --}}
@extends('layouts.home')

@section('title', 'Member Dashboard')

@section('css')
    <style>
        /* Member Container - Light Theme */
        .member-container {
            padding: 30px;
        }

        /* Welcome Section - Light Theme */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 85, 0, 0.05));
            border: 1px solid var(--border-primary);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .member-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar i {
            font-size: 3rem;
            color: white;
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-text h1 {
            color: var(--dark);
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .welcome-text p {
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
        }

        .welcome-text p i {
            color: var(--primary);
            width: 20px;
        }

        .membership-badge {
            background: var(--primary);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        /* Stats Grid - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.classes {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon.attendance {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.rate {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
        }

        .stat-icon.week {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 1.8rem;
            margin: 0;
            font-weight: 700;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
            font-weight: 500;
        }

        /* Dashboard Grid - Light Theme */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Dashboard Cards - Light Theme */
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

        /* Class List - Light Theme */
        .class-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .class-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .class-item:last-child {
            border-bottom: none;
        }

        .class-item:hover {
            background: var(--primary-light);
            transform: translateX(5px);
        }

        .class-time {
            min-width: 80px;
            text-align: center;
        }

        .class-time .date {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .class-time .day {
            color: var(--gray);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .class-info {
            flex: 1;
        }

        .class-info h4 {
            color: var(--dark);
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .class-info p {
            color: var(--gray);
            margin: 2px 0;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .class-info p i {
            color: var(--primary);
            width: 16px;
        }

        .class-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-upcoming {
            background: rgba(255, 85, 0, 0.15);
            color: var(--primary);
            border: 1px solid var(--border-primary);
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        /* Check-in Button */
        .btn-checkin {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-checkin:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.3);
        }

        .btn-checkin:disabled {
            background: var(--gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Attendance Table - Light Theme */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th {
            text-align: left;
            padding: 12px;
            color: var(--gray);
            font-weight: 700;
            font-size: 0.8rem;
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .attendance-table td {
            padding: 12px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
        }

        .attendance-table tbody tr {
            transition: var(--transition);
        }

        .attendance-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-present {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-late {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .status-absent {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Quick Links - Light Theme */
        .quick-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .quick-link {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: var(--dark);
            text-decoration: none;
            transition: var(--transition);
            display: block;
        }

        .quick-link:hover {
            background: var(--primary);
            transform: translateY(-3px);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .quick-link i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
            transition: var(--transition);
        }

        .quick-link:hover i {
            color: white;
            transform: scale(1.1);
        }

        .quick-link span {
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Progress Bar - Light Theme */
        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--secondary-light);
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            color: var(--gray);
            font-size: 0.8rem;
            margin-top: 5px;
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
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .view-all a:hover {
            color: var(--primary-dark);
            gap: 10px;
        }

        /* Current Plan Card */
        .current-plan {
            background: linear-gradient(135deg, var(--primary-light), white);
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid var(--border-primary);
        }

        .current-plan h4 {
            color: var(--primary);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .plan-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .plan-expiry {
            color: var(--gray);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .member-container {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .member-container {
                padding: 15px;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .class-item {
                flex-wrap: wrap;
            }

            .class-time {
                min-width: auto;
            }

            .btn-checkin {
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .attendance-table {
                display: block;
                overflow-x: auto;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 8px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .member-container {
                padding: 10px;
            }

            .welcome-text h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .stat-info h3 {
                font-size: 1.2rem;
            }

            .member-avatar {
                width: 80px;
                height: 80px;
            }

            .member-avatar i {
                font-size: 2rem;
            }
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section,
        .stat-card,
        .dashboard-card {
            animation: slideInUp 0.4s ease forwards;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
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

        /* Hover Effects for Class Items */
        .class-item {
            position: relative;
            overflow: hidden;
        }

        .class-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 85, 0, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .class-item:hover::before {
            left: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="member-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="member-avatar">
                @if ($member->photo)
                    <img src="{{ asset('admin/uploads/' . $member->photo) }}" alt="{{ $member->name }}">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
            </div>
            <div class="welcome-text">
                <h1>Welcome back, {{ $member->name }}! 👋</h1>
                <p><i class="fas fa-id-card"></i> Member ID: {{ $member->code ?? 'N/A' }}</p>
                <p><i class="fas fa-envelope"></i> {{ $member->email }}</p>
                <p><i class="fas fa-phone"></i> {{ $member->phone ?? 'No phone' }}</p>
            </div>
            <div class="membership-badge">
                <i class="fas fa-crown"></i>
                @if ($planDetails)
                    {{ $planDetails->type ?? 'Premium' }} Member
                @else
                    Active Member
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon classes">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalClasses }}</h3>
                    <p>Total Classes</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon attendance">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $presentClasses }}</h3>
                    <p>Classes Attended</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon rate">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $attendanceRate }}%</h3>
                    <p>Attendance Rate</p>
                    <div class="progress-bar" style="width: 100%; margin-top: 5px;">
                        <div class="progress-fill" style="width: {{ $attendanceRate }}%;"></div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon week">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $weekAttendance }}</h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>

        <!-- Next Class & Membership Info -->
        <div class="dashboard-grid">
            <!-- Upcoming Classes -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-alt"></i> Upcoming Classes</h3>
                    <span class="badge">{{ $upcomingClasses->count() }} classes</span>
                </div>
                <div class="card-body">
                    @if ($upcomingClasses->count() > 0)
                        <ul class="class-list">
                            @foreach ($upcomingClasses as $class)
                                <li class="class-item">
                                    <div class="class-time">
                                        <div class="date">{{ Carbon\Carbon::parse($class->start_date)->format('d M') }}
                                        </div>
                                        <div class="day">{{ Carbon\Carbon::parse($class->start_date)->format('D') }}
                                        </div>
                                    </div>
                                    <div class="class-info">
                                        <h4>{{ $class->course->name ?? 'Class' }}</h4>
                                        <p><i class="fas fa-clock"></i> {{ $class->formatted_time }}</p>
                                        <p><i class="fas fa-user-tie"></i> {{ $class->trainer->name ?? 'Trainer' }}</p>
                                    </div>
                                    @if (Carbon\Carbon::parse($class->start_date)->isToday())
                                        <form action="{{ route('member.checkin', $class->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-checkin"
                                                @if (Carbon\Carbon::now()->lt(Carbon\Carbon::parse($class->start_date . ' ' . $class->start_time)->subMinutes(15))) disabled title="Check-in opens 15 minutes before class" @endif>
                                                <i class="fas fa-sign-in-alt"></i>
                                                Check In
                                            </button>
                                        </form>
                                    @else
                                        <span class="class-status status-upcoming">Upcoming</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <div style="margin-top: 15px; text-align: right;">
                            <a href="{{ route('member.schedule') }}" style="color: var(--primary); text-decoration: none;">
                                View Full Schedule <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @else
                        <p style="color: var(--gray-light); text-align: center; padding: 20px;">
                            <i class="fas fa-calendar-times"></i> No upcoming classes
                        </p>
                    @endif
                </div>
            </div>

            <!-- Membership Info -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-id-card"></i> Membership Info</h3>
                </div>
                <div class="card-body">
                    @if ($membership)
                        <div style="text-align: center; margin-bottom: 20px;">
                            <div style="font-size: 3rem; color: var(--primary); margin-bottom: 10px;">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h4 style="color: white;">{{ $planDetails->type ?? 'Premium Plan' }}</h4>
                            <p style="color: var(--gray-light);">Active Membership</p>
                        </div>

                        <div
                            style="background: var(--dark-light); border-radius: 10px; padding: 15px; margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: white;">
                                <span>Enrolled:</span>
                                <span>{{ Carbon\Carbon::parse($membership->pivot->enrolled_date)->format('M d, Y') }}</span>
                            </div>
                            @if ($membership->pivot->expiry_date)
                                <div
                                    style="display: flex; justify-content: space-between; margin-bottom: 10px; color: white;">
                                    <span>Expires:</span>
                                    <span>{{ Carbon\Carbon::parse($membership->pivot->expiry_date)->format('M d, Y') }}</span>
                                </div>
                                @if ($daysUntilExpiry > 0)
                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                            style="width: {{ min(100, ((30 - $daysUntilExpiry) / 30) * 100) }}%;"></div>
                                    </div>
                                    <p style="color: var(--gray-light); text-align: center; margin-top: 10px;">
                                        {{ $daysUntilExpiry }} days remaining
                                    </p>
                                @else
                                    <p style="color: var(--danger); text-align: center; margin-top: 10px;">
                                        <i class="fas fa-exclamation-triangle"></i> Membership expired
                                    </p>
                                @endif
                            @endif
                        </div>
                    @else
                        <p style="color: var(--gray-light); text-align: center; padding: 20px;">
                            <i class="fas fa-info-circle"></i> No active membership
                        </p>
                    @endif

                    <div class="quick-links">
                        <a href="{{ route('member.attendance') }}" class="quick-link">
                            <i class="fas fa-history"></i>
                            <span>Attendance History</span>
                        </a>
                        <a href="{{ route('member.profile') }}" class="quick-link">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Recent Attendance</h3>
                <span class="badge">Last 30 days</span>
            </div>
            <div class="card-body">
                @if ($recentAttendance->count() > 0)
                    <div class="table-responsive">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Class</th>
                                    <th>Trainer</th>
                                    <th>Status</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAttendance as $record)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($record->start_date)->format('M d, Y') }}</td>
                                        <td>{{ $record->course_name }}</td>
                                        <td>{{ $record->trainer_name }}</td>
                                        <td>
                                            @if ($record->attendance_status)
                                                <span class="status-badge status-{{ $record->attendance_status }}">
                                                    {{ ucfirst($record->attendance_status) }}
                                                </span>
                                            @else
                                                <span class="status-badge">Not marked</span>
                                            @endif
                                        </td>
                                        <td>{{ $record->check_in_time ?? '--:--' }}</td>
                                        <td>{{ $record->check_out_time ?? '--:--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 20px;">
                        <i class="fas fa-calendar-times"></i> No attendance records found
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
