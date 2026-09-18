{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.home')

@section('title', 'Dashboard')

@section('css')
    <style>
        /* Stats Cards */
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

        .stat-icon.enrollment {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
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
            margin: 8px 0 0;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Stat Trend Indicator */
        .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .stat-trend.up {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-trend.down {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        .stat-trend.neutral {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-trend i {
            font-size: 0.7rem;
        }

        /* Stat Footer */
        .stat-footer {
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 5px;
        }

        .stat-change {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-change.positive {
            color: var(--success);
        }

        .stat-change.negative {
            color: var(--danger);
        }

        .stat-period {
            color: var(--gray);
            font-size: 0.7rem;
        }

        /* Small Stat Card Variation */
        .stat-card.small {
            padding: 18px;
        }

        .stat-card.small .stat-icon {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
        }

        .stat-card.small .stat-info h3 {
            font-size: 1.5rem;
        }

        .stat-card.small .stat-info p {
            font-size: 0.8rem;
        }

        /* Large Stat Card Variation */
        .stat-card.large {
            padding: 30px;
        }

        .stat-card.large .stat-icon {
            width: 75px;
            height: 75px;
            font-size: 2.2rem;
        }

        .stat-card.large .stat-info h3 {
            font-size: 2.5rem;
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

        .stat-card {
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

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                gap: 15px;
            }

            .stat-card {
                padding: 20px;
                gap: 15px;
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
                padding: 18px;
            }

            .stat-icon {
                margin-bottom: 10px;
            }

            .stat-footer {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                flex-direction: row;
                text-align: left;
                padding: 15px;
            }

            .stat-icon {
                margin-bottom: 0;
            }

            .stat-info h3 {
                font-size: 1.3rem;
            }

            .stat-footer {
                justify-content: flex-start;
            }
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

        /* Dark Mode Support (if needed) */
        @media (prefers-color-scheme: dark) {
            .stat-card {
                background: var(--secondary-light);
            }

            .stat-info h3 {
                color: white;
            }

            .stat-info p {
                color: var(--gray-light);
            }
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-content" style="padding: 20px;">

        <!-- Statistics Cards -->
        <div class="stats-grid">
            @php
                // Get real data from your database
                $totalMembers = \App\Models\Member::where('status', 'active')->count();
                $totalTrainers = \App\Models\Trainer::where('status', 1)->count();
                $todayClasses = \App\Models\ClassInstance::whereDate('start_date', today())->count();
                $activeSchedules = \App\Models\Schedule::where('status', 1)->count();

                // Today's attendance
$todayAttendance = \DB::table('class_instance_member')
    ->join('class_instances', 'class_instance_member.class_instance_id', '=', 'class_instances.id')
    ->whereDate('class_instances.start_date', today())
    ->whereIn('class_instance_member.attendance_status', ['present', 'late'])
                    ->count();
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
                <div class="stat-icon classes">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $todayAttendance }}</h3>
                    <p>Checked In Today</p>
                </div>
            </div>
        </div>

        <!-- Today's Classes -->
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
                                <i class="fas fa-users" style="width: 20px;"></i> {{ $present }}/{{ $enrolled }}
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

        <!-- Recent Members & Quick Actions -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Recent Members -->
            <div
                style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px;">
                <h3 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-user-plus" style="color: var(--primary);"></i>
                    Recent Members
                </h3>

                @php
                    $recentMembers = \App\Models\Member::orderBy('created_at', 'desc')->limit(5)->get();
                @endphp

                @if ($recentMembers->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach ($recentMembers as $member)
                            <div
                                style="display: flex; align-items: center; gap: 15px; padding: 10px; background: var(--dark-light); border-radius: 10px;">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user" style="color: var(--primary);"></i>
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="color: white; margin: 0;">{{ $member->name }}</h4>
                                    <p style="color: var(--gray-light); margin: 2px 0 0; font-size: 0.85rem;">
                                        {{ $member->code ?? 'No Code' }} • Joined
                                        {{ $member->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span
                                    style="background: rgba(40, 167, 69, 0.15); color: var(--success); padding: 3px 10px; border-radius: 12px; font-size: 0.8rem;">
                                    {{ ucfirst($member->status ?? 'active') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 20px;">No members yet</p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div
                style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px;">
                <h3 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-bolt" style="color: var(--primary);"></i>
                    Quick Actions
                </h3>

                <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                    <a href="{{ route('equipment.index') }}"
                        style="background: var(--dark-light); padding: 15px; border-radius: 10px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: var(--transition);">
                        <i class="fas fa-tools" style="color: var(--primary); width: 25px;"></i>
                        <span>Manage Equipment</span>
                        <i class="fas fa-arrow-right" style="margin-left: auto; color: var(--gray-light);"></i>
                    </a>

                    <a href="{{ route('attendance.today') }}"
                        style="background: var(--dark-light); padding: 15px; border-radius: 10px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: var(--transition);">
                        <i class="fas fa-clipboard-check" style="color: var(--primary); width: 25px;"></i>
                        <span>Today's Attendance</span>
                        <i class="fas fa-arrow-right" style="margin-left: auto; color: var(--gray-light);"></i>
                    </a>

                    <a href="{{ route('reports.index') }}"
                        style="background: var(--dark-light); padding: 15px; border-radius: 10px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: var(--transition);">
                        <i class="fas fa-chart-bar" style="color: var(--primary); width: 25px;"></i>
                        <span>View Reports</span>
                        <i class="fas fa-arrow-right" style="margin-left: auto; color: var(--gray-light);"></i>
                    </a>

                    <a href="{{ route('equipment.maintenance.dashboard') }}"
                        style="background: var(--dark-light); padding: 15px; border-radius: 10px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: var(--transition);">
                        <i class="fas fa-wrench" style="color: var(--primary); width: 25px;"></i>
                        <span>Maintenance</span>
                        <i class="fas fa-arrow-right" style="margin-left: auto; color: var(--gray-light);"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Classes & Expiring Memberships -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Upcoming Classes (Next 7 days) -->
            <div
                style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px;">
                <h3 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-calendar-week" style="color: var(--primary);"></i>
                    This Week's Classes
                </h3>

                @php
                    $weekClasses = \App\Models\ClassInstance::with(['course', 'trainer'])
                        ->whereBetween('start_date', [today(), today()->addDays(7)])
                        ->orderBy('start_date')
                        ->orderBy('start_time')
                        ->limit(5)
                        ->get();
                @endphp

                @if ($weekClasses->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach ($weekClasses as $class)
                            <div
                                style="display: flex; align-items: center; gap: 15px; padding: 10px; background: var(--dark-light); border-radius: 10px;">
                                <div style="min-width: 60px; text-align: center;">
                                    <span
                                        style="color: var(--primary); font-weight: 600;">{{ $class->start_date->format('d M') }}</span>
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="color: white; margin: 0;">{{ $class->course->name ?? 'Class' }}</h4>
                                    <p style="color: var(--gray-light); margin: 2px 0 0; font-size: 0.85rem;">
                                        {{ $class->trainer->name ?? 'No Trainer' }} •
                                        {{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}
                                    </p>
                                </div>
                                <span
                                    style="background: var(--primary-light); color: var(--primary); padding: 3px 10px; border-radius: 12px; font-size: 0.8rem;">
                                    {{ $class->member()->count() }}/{{ $class->total_spots }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 20px;">No classes scheduled this week
                    </p>
                @endif
            </div>

            <!-- Expiring Soon Memberships -->
            <div
                style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px;">
                <h3 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-clock" style="color: var(--warning);"></i>
                    Expiring Soon
                </h3>

                @php
                    $expiringMembers = \App\Models\Member::whereHas('schedule', function ($q) {
                        $q->where('member_schedule.expiry_date', '<=', today()->addDays(7))
                            ->where('member_schedule.expiry_date', '>=', today())
                            ->where('member_schedule.status', 'active');
                    })
                        ->with([
                            'schedule' => function ($q) {
                                $q->wherePivot('expiry_date', '<=', today()->addDays(7))->wherePivot(
                                    'expiry_date',
                                    '>=',
                                    today(),
                                );
                            },
                        ])
                        ->limit(5)
                        ->get();
                @endphp

                @if ($expiringMembers->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach ($expiringMembers as $member)
                            @foreach ($member->schedule as $schedule)
                                <div
                                    style="display: flex; align-items: center; gap: 15px; padding: 10px; background: var(--dark-light); border-radius: 10px;">
                                    <div
                                        style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255, 193, 7, 0.15); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user" style="color: var(--warning);"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h4 style="color: white; margin: 0;">{{ $member->name }}</h4>
                                        <p style="color: var(--gray-light); margin: 2px 0 0; font-size: 0.85rem;">
                                            Expires:
                                            {{ \Carbon\Carbon::parse($schedule->pivot->expiry_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <span
                                        style="background: rgba(255, 193, 7, 0.15); color: var(--warning); padding: 3px 10px; border-radius: 12px; font-size: 0.8rem;">
                                        {{ \Carbon\Carbon::parse($schedule->pivot->expiry_date)->diffInDays(today()) }}
                                        days
                                    </span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 20px;">No expiring memberships</p>
                @endif
            </div>
        </div>

        <!-- Equipment Status -->
        <div
            style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px; margin-top: 30px;">
            <h3 style="color: white; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-tools" style="color: var(--primary);"></i>
                Equipment Status
            </h3>

            @php
                $totalEquipment = \App\Models\Equipment::count();
                $availableEquipment = \App\Models\Equipment::where('status', 'available')->sum('available_quantity');
                $inUseEquipment = \App\Models\Equipment::where('status', 'in_use')->count();
                $maintenanceEquipment = \App\Models\Equipment::whereIn('status', ['maintenance', 'broken'])->count();
            @endphp

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="text-align: center;">
                    <span style="color: white; font-size: 1.8rem; font-weight: 700;">{{ $totalEquipment }}</span>
                    <p style="color: var(--gray-light); margin: 5px 0 0;">Total Items</p>
                </div>
                <div style="text-align: center;">
                    <span
                        style="color: var(--success); font-size: 1.8rem; font-weight: 700;">{{ $availableEquipment }}</span>
                    <p style="color: var(--gray-light); margin: 5px 0 0;">Available</p>
                </div>
                <div style="text-align: center;">
                    <span style="color: #17a2b8; font-size: 1.8rem; font-weight: 700;">{{ $inUseEquipment }}</span>
                    <p style="color: var(--gray-light); margin: 5px 0 0;">In Use</p>
                </div>
                <div style="text-align: center;">
                    <span
                        style="color: var(--warning); font-size: 1.8rem; font-weight: 700;">{{ $maintenanceEquipment }}</span>
                    <p style="color: var(--gray-light); margin: 5px 0 0;">Maintenance</p>
                </div>
            </div>

            <a href="{{ route('equipment.index') }}"
                style="color: var(--primary); text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                View All Equipment <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection
