{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.home')

@section('title', 'Dashboard')

@section('css')
    <style>
        /* Stats Cards - Light Theme */
        /* Stats Grid - Light Theme */
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
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            transition: var(--transition);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.05);
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

        .stat-icon.revenue {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-info {
            flex: 1;
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 2rem;
            margin: 0;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
            font-weight: 500;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-trend.up {
            color: var(--success);
        }

        .stat-trend.down {
            color: var(--danger);
        }

        .stat-trend.neutral {
            color: var(--warning);
        }

        /* Performance Cards - Light Theme */
        .performance-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .performance-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .performance-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-color: var(--border-primary);
        }

        .performance-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            padding: 20px 25px;
            border-bottom: 2px solid var(--primary);
        }

        .performance-header h3 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.2rem;
        }

        .performance-header h3 i {
            color: var(--primary);
            font-size: 1.3rem;
        }

        .performance-header .header-badge {
            background: var(--primary);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: auto;
        }

        .performance-body {
            padding: 20px 25px;
        }

        .performance-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .performance-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .performance-item:last-child {
            border-bottom: none;
        }

        .performance-item:hover {
            background: var(--primary-light);
            padding-left: 12px;
            margin-left: -12px;
            padding-right: 12px;
            margin-right: -12px;
            border-radius: 10px;
        }

        .item-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-name {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .item-name .badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 50px;
            font-weight: 600;
        }

        .item-meta {
            color: var(--gray);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 3px;
        }

        .item-meta i {
            color: var(--primary);
            width: 14px;
            font-size: 0.7rem;
        }

        .item-value {
            text-align: right;
        }

        .item-amount {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .item-change {
            font-size: 0.7rem;
            margin-top: 3px;
        }

        .item-change.positive {
            color: var(--success);
        }

        .item-change.negative {
            color: var(--danger);
        }

        /* Rank Badges */
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            border-radius: 50%;
            font-weight: 700;
            color: var(--primary);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .rank-1 {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }

        .rank-2 {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
        }

        .rank-3 {
            background: rgba(205, 92, 92, 0.15);
            color: #cd5c5c;
        }

        /* No Data State */
        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
            color: var(--primary);
        }

        .no-data p {
            margin: 0;
        }

        /* Dashboard Stats - Light Theme */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
        }

        .dashboard-stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), transparent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .dashboard-stat-card:hover::after {
            transform: scaleX(1);
        }

        .stat-icon-circle {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: var(--transition);
        }

        .dashboard-stat-card:hover .stat-icon-circle {
            transform: scale(1.05);
        }

        .stat-icon-circle.primary {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon-circle.success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon-circle.info {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
        }

        .stat-icon-circle.warning {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-icon-circle.danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        .stat-content {
            flex: 1;
        }

        .stat-content h3 {
            font-size: 1.8rem;
            margin: 0;
            color: var(--dark);
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-content p {
            margin: 5px 0 0;
            color: var(--gray);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-trend.up {
            color: var(--success);
        }

        .stat-trend.down {
            color: var(--danger);
        }

        .stat-trend i {
            font-size: 0.7rem;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .stats-grid {
                gap: 15px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .performance-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .stat-icon {
                margin-bottom: 10px;
            }

            .performance-header {
                padding: 15px 20px;
            }

            .performance-header h3 {
                font-size: 1rem;
            }

            .performance-body {
                padding: 15px 20px;
            }

            .performance-item {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .item-info {
                flex-direction: column;
                text-align: center;
            }

            .item-value {
                text-align: center;
            }

            .rank-badge {
                margin: 0 auto 5px;
            }

            .item-name {
                justify-content: center;
            }

            .item-meta {
                justify-content: center;
            }

            .dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .performance-header {
                padding: 12px 15px;
            }

            .performance-body {
                padding: 12px 15px;
            }

            .stat-content h3 {
                font-size: 1.5rem;
            }
        }

        /* Animations */
        @keyframes statCardAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .dashboard-stat-card,
        .performance-card {
            animation: statCardAppear 0.3s ease forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(5) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(6) {
            animation-delay: 0.25s;
        }

        .dashboard-stat-card:nth-child(1) {
            animation-delay: 0s;
        }

        .dashboard-stat-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .dashboard-stat-card:nth-child(3) {
            animation-delay: 0.1s;
        }

        .dashboard-stat-card:nth-child(4) {
            animation-delay: 0.15s;
        }

        /* Loading Skeleton */
        .skeleton-stat-card {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: var(--border-radius);
            padding: 25px;
            height: 120px;
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
    <div class="dashboard-content" style="padding: 20px;">

        <!-- Statistics Cards -->
        <div class="stats-grid">
            @php
                $totalMembers = \App\Models\Member::where('status', 'active')->count();
                $totalTrainers = \App\Models\Trainer::where('status', 1)->count();
                $todayClasses = \App\Models\ClassInstance::whereDate('start_date', today())->count();

                $todayAttendance = \DB::table('class_instance_member')
                    ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
                    ->whereDate('class_instances.start_date', today())
                    ->whereIn('class_instance_member.attendance_status', ['present', 'late'])
                    ->count();

                $totalRevenue = \App\Models\Payment::sum('amount');
            @endphp

            <div class="stat-card">
                <div class="stat-icon members">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalMembers }}</h3>
                    <p>Active Members</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon trainers">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalTrainers }}</h3>
                    <p>Trainers</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon classes">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $todayClasses }}</h3>
                    <p>Classes Today</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon attendance">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $todayAttendance }}</h3>
                    <p>Checked In Today</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Performance Analytics - Based on Member Enrollments -->
        @php
            // Calculate courses by number of enrolled members
            $coursesByMembers = \App\Models\Course::withCount('schedules')
                ->get()
                ->map(function ($course) {
                    // Count total members enrolled in this course through schedules
                    $memberCount = \App\Models\MemberSchedule::whereHas('schedule', function ($q) use ($course) {
                        $q->where('course_id', $course->id);
                    })->count();

                    return [
                        'id' => $course->id,
                        'name' => $course->name,
                        'member_count' => $memberCount,
                    ];
                })
                ->sortByDesc('member_count')
                ->values();

            $topCourses = $coursesByMembers->take(3);
            $bottomCourses = $coursesByMembers
                ->take(-3)
                ->reverse()
                ->values();

            // Calculate trainers by number of members they train
            $trainersByMembers = \App\Models\Trainer::withCount('schedules')
                ->get()
                ->map(function ($trainer) {
                    // Count total members trained by this trainer
                    $memberCount = \App\Models\MemberSchedule::whereHas('schedule', function ($q) use ($trainer) {
                        $q->where('trainer_id', $trainer->id);
                    })->count();

                    return [
                        'id' => $trainer->id,
                        'name' => $trainer->name,
                        'member_count' => $memberCount,
                        'courses_count' => $trainer->courses->count(),
                    ];
                })
                ->sortByDesc('member_count')
                ->values();

            $topTrainers = $trainersByMembers->take(3);
            $bottomTrainers = $trainersByMembers
                ->take(-3)
                ->reverse()
                ->values();
        @endphp

        <div class="performance-grid">
            <!-- Top Courses (Most Members) -->
            <div class="performance-card">
                <div class="performance-header">
                    <h3>
                        <i class="fas fa-trophy"></i>
                        Most Popular Courses
                    </h3>
                </div>
                <div class="performance-body">
                    @if ($topCourses->count() > 0 && $topCourses->sum('member_count') > 0)
                        <ul class="performance-list">
                            @foreach ($topCourses as $index => $course)
                                <li class="performance-item">
                                    <div class="item-info">
                                        <div class="item-name">
                                            <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                            {{ Str::limit($course['name'], 35) }}
                                        </div>
                                        <div class="item-meta">
                                            <i class="fas fa-users"></i> {{ $course['member_count'] }} members enrolled
                                        </div>
                                    </div>
                                    <div class="item-value">
                                        <div class="item-amount">{{ $course['member_count'] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="no-data">
                            <i class="fas fa-chart-line"></i>
                            <p>No enrollment data available yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Top Trainers (Most Members) -->
            <div class="performance-card">
                <div class="performance-header">
                    <h3>
                        <i class="fas fa-crown"></i>
                        Top Performing Trainers
                    </h3>
                </div>
                <div class="performance-body">
                    @if ($topTrainers->count() > 0 && $topTrainers->sum('member_count') > 0)
                        <ul class="performance-list">
                            @foreach ($topTrainers as $index => $trainer)
                                <li class="performance-item">
                                    <div class="item-info">
                                        <div class="item-name">
                                            <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                            {{ Str::limit($trainer['name'], 25) }}
                                        </div>
                                        <div class="item-meta">
                                            <i class="fas fa-book"></i> {{ $trainer['courses_count'] }} courses •
                                            <i class="fas fa-users"></i> {{ $trainer['member_count'] }} members
                                        </div>
                                    </div>
                                    <div class="item-value">
                                        <div class="item-amount">{{ $trainer['member_count'] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="no-data">
                            <i class="fas fa-chart-line"></i>
                            <p>No trainer data available yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="performance-grid">
            <!-- Least Popular Courses (Need Improvement) -->
            <div class="performance-card">
                <div class="performance-header">
                    <h3>
                        <i class="fas fa-chart-line"></i>
                        Courses Needing Improvement
                    </h3>
                </div>
                <div class="performance-body">
                    @if ($bottomCourses->count() > 0 && $bottomCourses->sum('member_count') >= 0)
                        @php $hasData = false; @endphp
                        @foreach ($bottomCourses as $index => $course)
                            @if ($course['member_count'] == 0)
                                @php $hasData = true; @endphp
                                <li class="performance-item">
                                    <div class="item-info">
                                        <div class="item-name">
                                            <span class="rank-badge">{{ $index + 1 }}</span>
                                            {{ Str::limit($course['name'], 35) }}
                                        </div>
                                        <div class="item-meta">
                                            <i class="fas fa-users"></i> No members yet
                                        </div>
                                    </div>
                                    <div class="item-value">
                                        <div class="item-amount" style="color: var(--danger);">0</div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        @if (!$hasData)
                            <div class="no-data">
                                <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                <p>All courses have members! Great job!</p>
                            </div>
                        @endif
                    @else
                        <div class="no-data">
                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                            <p>All courses are doing well!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Trainers Needing Improvement -->
            <div class="performance-card">
                <div class="performance-header">
                    <h3>
                        <i class="fas fa-exclamation-triangle"></i>
                        Trainers Needing Improvement
                    </h3>
                </div>
                <div class="performance-body">
                    @if ($bottomTrainers->count() > 0 && $bottomTrainers->sum('member_count') >= 0)
                        @php $hasData = false; @endphp
                        @foreach ($bottomTrainers as $index => $trainer)
                            @if ($trainer['member_count'] == 0)
                                @php $hasData = true; @endphp
                                <li class="performance-item">
                                    <div class="item-info">
                                        <div class="item-name">
                                            <span class="rank-badge">{{ $index + 1 }}</span>
                                            {{ Str::limit($trainer['name'], 25) }}
                                        </div>
                                        <div class="item-meta">
                                            <i class="fas fa-book"></i> {{ $trainer['courses_count'] }} courses • No
                                            members yet
                                        </div>
                                    </div>
                                    <div class="item-value">
                                        <div class="item-amount" style="color: var(--danger);">0</div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        @if (!$hasData)
                            <div class="no-data">
                                <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                <p>All trainers have members! Great job!</p>
                            </div>
                        @endif
                    @else
                        <div class="no-data">
                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                            <p>All trainers are doing well!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Today's Classes (rest of your existing code remains the same) -->
        <div
            style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px; margin-bottom: 30px;">
            <h3 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clock" style="color: var(--primary);"></i>
                Today's Classes
            </h3>

            @php
                $todaysClasses = \App\Models\ClassInstance::with(['course', 'trainer', 'schedule'])
                    ->whereDate('start_date', today())
                    ->orderBy('start_time')
                    ->get();
            @endphp

            @if ($todaysClasses->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
                    @foreach ($todaysClasses as $class)
                        @php
                            $enrolled = $class->member()->count();
                            $present = $class->member()->wherePivot('attendance_status', 'present')->count();
                        @endphp
                        <div
                            style="background: var(--dark-light); border-radius: 10px; padding: 15px; border-left: 4px solid var(--primary);">
                            <div
                                style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <h4 style="color: white; margin: 0;">{{ $class->course->name ?? 'Class' }}</h4>
                                <span
                                    style="background: var(--primary-light); color: var(--primary); padding: 3px 10px; border-radius: 12px; font-size: 0.8rem;">
                                    {{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}
                                </span>
                            </div>
                            <p style="color: var(--gray-light); margin: 5px 0;">
                                <i class="fas fa-user-tie" style="width: 20px;"></i>
                                {{ $class->trainer->name ?? 'No Trainer' }}
                            </p>
                            <p style="color: var(--gray-light); margin: 5px 0;">
                                <i class="fas fa-users" style="width: 20px;"></i>
                                {{ $present }}/{{ $enrolled }}
                                present
                            </p>
                            <a href="{{ route('attendance.class', $class->id) }}"
                                style="color: var(--primary); text-decoration: none; font-size: 0.9rem; display: inline-block; margin-top: 10px;">
                                Mark Attendance <i class="fas fa-arrow-right"></i>
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

        <!-- Recent Members & Quick Actions (keep your existing code here) -->
        <!-- ... rest of your existing code for Recent Members, Quick Actions, Upcoming Classes, Expiring Memberships, Equipment Status ... -->

    </div>
@endsection
