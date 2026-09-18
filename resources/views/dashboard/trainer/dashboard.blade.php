@extends('layouts.home')

@section('title', 'Trainer Dashboard')

@section('css')
    <style>
        /* Trainer Container - Light Theme */
        .trainer-container {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: var(--dark);
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header h1 i {
            color: var(--primary);
        }

        /* Welcome Card - Light Theme */
        .welcome-card {
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 85, 0, 0.05));
            border: 1px solid var(--border-primary);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .welcome-text h2 {
            color: var(--dark);
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .welcome-text p {
            color: var(--gray);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .welcome-text p i {
            color: var(--primary);
        }

        .date-badge {
            background: white;
            padding: 12px 25px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark);
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .date-badge i {
            color: var(--primary);
            font-size: 1.2rem;
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

        .stat-icon.members {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.attendance {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
        }

        .stat-icon.rate {
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
            grid-template-columns: 1fr 1fr;
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

        /* Today's Classes - Light Theme */
        .today-classes {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .class-item {
            background: var(--secondary-light);
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .class-item:hover {
            transform: translateX(5px);
            border-left-color: var(--primary);
            background: var(--primary-light);
        }

        .class-time {
            min-width: 100px;
            text-align: center;
        }

        .class-time .time {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .class-time .date {
            color: var(--gray);
            font-size: 0.8rem;
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
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .class-info p i {
            color: var(--primary);
            width: 16px;
        }

        .class-stats {
            display: flex;
            gap: 20px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .class-stats span {
            color: var(--gray);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .class-stats span i {
            color: var(--primary);
        }

        /* Button - Light Theme */
        .btn-class {
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
            gap: 5px;
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-class:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.3);
        }

        /* Upcoming Classes List - Light Theme */
        .upcoming-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .upcoming-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .upcoming-item:last-child {
            border-bottom: none;
        }

        .upcoming-item:hover {
            background: var(--primary-light);
            padding-left: 10px;
            margin-left: -10px;
            border-radius: 8px;
        }

        .upcoming-date {
            min-width: 70px;
            text-align: center;
        }

        .upcoming-date .day {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .upcoming-date .month {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .upcoming-info {
            flex: 1;
        }

        .upcoming-info h4 {
            color: var(--dark);
            margin-bottom: 3px;
            font-size: 0.95rem;
        }

        .upcoming-info p {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .upcoming-info p i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Recent Attendance - Light Theme */
        .attendance-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .attendance-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .attendance-item:last-child {
            border-bottom: none;
        }

        .attendance-item:hover {
            background: var(--primary-light);
            padding-left: 10px;
            margin-left: -10px;
            border-radius: 8px;
        }

        .member-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .attendance-info {
            flex: 1;
        }

        .attendance-info h4 {
            color: var(--dark);
            margin-bottom: 3px;
            font-size: 0.95rem;
        }

        .attendance-info p {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .attendance-info p i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Attendance Badges - Light Theme */
        .attendance-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-present {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .badge-late {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .badge-absent {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Quick Actions - Light Theme */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }

        .quick-action {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            transition: var(--transition);
        }

        .quick-action:hover {
            background: var(--primary);
            transform: translateY(-5px);
            border-color: var(--primary);
        }

        .quick-action i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
            transition: var(--transition);
        }

        .quick-action:hover i {
            color: white;
            transform: scale(1.1);
        }

        .quick-action span {
            color: var(--dark);
            font-weight: 600;
            transition: var(--transition);
        }

        .quick-action:hover span {
            color: white;
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

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .trainer-container {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .trainer-container {
                padding: 15px;
            }

            .welcome-card {
                flex-direction: column;
                text-align: center;
            }

            .welcome-text h2 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .class-item {
                flex-direction: column;
                text-align: center;
            }

            .class-time {
                min-width: auto;
            }

            .class-stats {
                justify-content: center;
            }

            .btn-class {
                width: 100%;
                justify-content: center;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .upcoming-item,
            .attendance-item {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .trainer-container {
                padding: 10px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .welcome-card {
                padding: 20px;
            }

            .welcome-text h2 {
                font-size: 1.3rem;
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
                font-size: 1.3rem;
            }

            .stat-info h3 {
                font-size: 1.3rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .member-avatar {
                width: 40px;
                height: 40px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-card,
        .stat-card,
        .dashboard-card {
            animation: fadeInUp 0.4s ease forwards;
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

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="trainer-container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-text">
                <h2>Welcome back, {{ $trainer->name }}! 👋</h2>
                <p>Ready to train and inspire today?</p>
            </div>
            <div class="date-badge">
                <i class="fas fa-calendar-day"></i>
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon classes">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_classes'] }}</h3>
                    <p>Total Classes</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon members">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_members'] }}</h3>
                    <p>Members Trained</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon attendance">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['classes_this_month'] }}</h3>
                    <p>Classes This Month</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon rate">
                    <i class="fas fa-percent"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['attendance_rate'] }}%</h3>
                    <p>Attendance Rate</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Today's Classes -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-clock"></i> Today's Classes</h3>
                    <span class="badge">{{ $todayClasses->count() }} classes</span>
                </div>
                <div class="card-body">
                    @if ($todayClasses->count() > 0)
                        <div class="today-classes">
                            @foreach ($todayClasses as $class)
                                <div class="class-item">
                                    <div class="class-time">
                                        <div class="time">{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}
                                        </div>
                                        <div class="date">{{ $class->start_date->format('M d') }}</div>
                                    </div>
                                    <div class="class-info">
                                        <h4>{{ $class->course->name ?? 'Class' }}</h4>
                                        <p>
                                            <span><i class="fas fa-users"></i> {{ $class->total_enrolled }} enrolled</span>
                                            <span><i class="fas fa-check-circle" style="color: var(--success);"></i>
                                                {{ $class->present_count }} present</span>
                                        </p>
                                        <div class="class-stats">
                                            <span><i class="fas fa-door-open"></i> Room:
                                                {{ $class->location ?? 'Main Studio' }}</span>
                                            <span><i class="fas fa-hourglass-half"></i>
                                                {{ \Carbon\Carbon::parse($class->start_time)->diffInMinutes(\Carbon\Carbon::parse($class->end_time)) }}
                                                min</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('trainer.class.details', $class->id) }}" class="btn-class">
                                        <i class="fas fa-clipboard-check"></i>
                                        Mark
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: var(--gray-light); text-align: center; padding: 20px;">
                            <i class="fas fa-calendar-times"></i> No classes scheduled for today
                        </p>
                    @endif
                </div>
            </div>

            <!-- Upcoming Classes -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-week"></i> Upcoming Classes</h3>
                    <span class="badge">Next 7 days</span>
                </div>
                <div class="card-body">
                    @if ($upcomingClasses->count() > 0)
                        <ul class="upcoming-list">
                            @foreach ($upcomingClasses as $class)
                                <li class="upcoming-item">
                                    <div class="upcoming-date">
                                        <div class="day">{{ $class->start_date->format('d') }}</div>
                                        <div class="month">{{ $class->start_date->format('M') }}</div>
                                    </div>
                                    <div class="upcoming-info">
                                        <h4>{{ $class->course->name ?? 'Class' }}</h4>
                                        <p>
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} •
                                            <i class="fas fa-users"></i>
                                            {{ $class->member->count() }}/{{ $class->total_spots }} enrolled
                                        </p>
                                    </div>
                                    <a href="{{ route('trainer.class.details', $class->id) }}" class="btn-class"
                                        style="padding: 5px 12px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div style="margin-top: 15px; text-align: right;">
                            <a href="{{ route('trainer.schedule') }}"
                                style="color: var(--primary); text-decoration: none;">
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
        </div>

        <!-- Recent Attendance -->
        <div class="dashboard-card" style="margin-bottom: 30px;">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Recent Attendance</h3>
            </div>
            <div class="card-body">
                @if ($recentAttendance->count() > 0)
                    <ul class="attendance-list">
                        @foreach ($recentAttendance as $attendance)
                            @php
                                $badgeClass = '';
                                if ($attendance->attendance_status == 'present') {
                                    $badgeClass = 'badge-present';
                                } elseif ($attendance->attendance_status == 'late') {
                                    $badgeClass = 'badge-late';
                                } elseif ($attendance->attendance_status == 'absent') {
                                    $badgeClass = 'badge-absent';
                                }
                            @endphp
                            <li class="attendance-item">
                                <div class="member-avatar">
                                    @if ($attendance->photo)
                                        <img src="{{ asset('admin/uploads/' . $attendance->photo) }}"
                                            alt="{{ $attendance->member_name }}">
                                    @else
                                        <i class="fas fa-user-circle"></i>
                                    @endif
                                </div>
                                <div class="attendance-info">
                                    <h4>{{ $attendance->member_name }}</h4>
                                    <p>
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($attendance->start_date)->format('M d, Y') }} •
                                        <i class="fas fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($attendance->start_time)->format('g:i A') }} •
                                        {{ $attendance->course_name }}
                                    </p>
                                </div>
                                <span class="attendance-badge {{ $badgeClass }}">
                                    {{ ucfirst($attendance->attendance_status) }}
                                    @if ($attendance->check_in_time)
                                        <small>({{ $attendance->check_in_time }})</small>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 20px;">
                        <i class="fas fa-info-circle"></i> No recent attendance records
                    </p>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('trainer.schedule') }}" class="quick-action">
                <i class="fas fa-calendar-alt"></i>
                <span>My Schedule</span>
            </a>
            <a href="{{ route('trainer.members') }}" class="quick-action">
                <i class="fas fa-users"></i>
                <span>My Members</span>
            </a>
            <a href="{{ route('trainer.statistics') }}" class="quick-action">
                <i class="fas fa-chart-bar"></i>
                <span>Statistics</span>
            </a>
            <a href="{{ route('attendance.today') }}" class="quick-action">
                <i class="fas fa-clipboard-list"></i>
                <span>Attendance</span>
            </a>
        </div>
    </div>
@endsection
