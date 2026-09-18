{{-- resources/views/attendance/today.blade.php --}}
@extends('layouts.home')

@section('title', "Today's Attendance - " . $today->format('F j, Y'))

@section('css')
    <style>
        /* Attendance Container - Light Theme */
        .attendance-container {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
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

        .date-badge {
            background: var(--primary-light);
            color: var(--dark);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border-primary);
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

        .stat-icon.total {
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
        }

        .stat-icon.expected {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .stat-icon.present {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.absent {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 1.8rem;
            margin: 0;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
        }

        /* Class Card - Light Theme */
        .class-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .class-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-bottom: 2px solid var(--primary);
        }

        .class-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .class-title h3 {
            color: var(--dark);
            margin: 0;
            font-size: 1.2rem;
        }

        .class-title .badge {
            background: var(--primary);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
        }

        .class-time {
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .class-time i {
            color: var(--primary);
        }

        /* Members Table - Light Theme */
        .members-table {
            width: 100%;
            border-collapse: collapse;
        }

        .members-table th {
            background: rgba(0, 0, 0, 0.03);
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .members-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
        }

        .members-table tr:last-child td {
            border-bottom: none;
        }

        .members-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Member Info - Light Theme */
        .member-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .member-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
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

        /* ADDED: Member overdue styling */
        .member-row-overdue {
            background: rgba(220, 53, 69, 0.05);
            border-left: 3px solid var(--danger);
        }

        .member-row-overdue td {
            background: rgba(220, 53, 69, 0.03);
        }

        .payment-warning-icon {
            color: var(--danger);
            font-size: 0.8rem;
            margin-left: 5px;
            cursor: help;
        }

        /* Payment Status Badge */
        .payment-status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
        }

        .payment-status-paid {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .payment-status-partial {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }

        .payment-status-pending {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
        }

        .payment-status-overdue {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }

        /* Status Badge - Light Theme */
        .status-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-present {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-late {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .status-absent {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .status-not-marked {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .check-time {
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* Buttons - Light Theme */
        .btn-mark {
            background: var(--primary);
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 5px rgba(255, 85, 0, 0.2);
        }

        .btn-mark:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-mark i {
            font-size: 0.8rem;
        }

        /* No Data - Light Theme */
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--gray);
            opacity: 0.5;
        }

        /* Header Actions - Light Theme */
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-calendar {
            background: white;
            color: var(--dark);
            border: 2px solid var(--primary);
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-calendar:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .btn-calendar i {
            color: var(--primary);
        }

        .btn-calendar:hover i {
            color: white;
        }

        /* Attendance Rate Bar - Light Theme */
        .attendance-rate-bar {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .rate-text {
            color: var(--dark);
            font-weight: 600;
        }

        .progress-bar-container {
            width: 200px;
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--success);
            border-radius: 5px;
            transition: width 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .members-table {
                display: block;
                overflow-x: auto;
            }

            .class-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-info h3 {
                font-size: 1.4rem;
            }

            .attendance-rate-bar {
                padding: 15px;
            }

            .progress-bar-container {
                width: 150px;
            }
        }

        @media (max-width: 576px) {
            .attendance-container {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .member-info {
                flex-direction: column;
                text-align: center;
            }

            .member-avatar {
                margin-bottom: 8px;
            }
        }

        /* Animation for alerts */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Alert wrapper */
        .alert {
            animation: slideIn 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <div class="attendance-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-clipboard-list"></i>
                Today's Attendance
            </h1>
            <div class="header-actions">
                <div class="date-badge">
                    <i class="fas fa-calendar-day"></i>
                    {{ $today->format('l, F j, Y') }}
                </div>
                <a href="{{ route('attendance.calendar') }}" class="btn-calendar">
                    <i class="fas fa-calendar-alt"></i>
                    Calendar View
                </a>
            </div>
        </div>

        <!-- Stats Cards (always show) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_classes'] }}</h3>
                    <p>Total Classes Today</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon expected">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_expected'] }}</h3>
                    <p>Expected Members</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon present">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_present'] }}</h3>
                    <p>Present / Late</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon absent">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_absent'] }}</h3>
                    <p>Absent</p>
                </div>
            </div>
        </div>

        <!-- Attendance Rate (always show) -->
        <div
            style="background: var(--secondary-light); border-radius: var(--border-radius); padding: 20px; margin-bottom: 30px; border: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-chart-line" style="color: var(--primary); font-size: 1.5rem;"></i>
                    <span style="color: white;">Attendance Rate Today</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div
                        style="width: 200px; height: 10px; background: var(--dark-light); border-radius: 5px; overflow: hidden;">
                        <div style="width: {{ $stats['attendance_rate'] }}%; height: 100%; background: var(--success);">
                        </div>
                    </div>
                    <span style="color: white; font-weight: 700;">{{ $stats['attendance_rate'] }}%</span>
                </div>
            </div>
        </div>

        <!-- Classes List -->
        @if ($classInstances->count() > 0)
            @foreach ($classInstances as $class)
                <div class="class-card">
                    <div class="class-header">
                        <div class="class-title">
                            <i class="fas fa-book-open" style="color: var(--primary);"></i>
                            <h3>{{ $class->course->name ?? 'N/A' }}</h3>
                            <span class="badge">
                                <i class="fas fa-chalkboard-teacher"></i>
                                {{ $class->trainer->name ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="class-time">
                            <i class="fas fa-clock"></i>
                            {{ Carbon\Carbon::parse($class->start_time)->format('g:i A') }} -
                            {{ Carbon\Carbon::parse($class->end_time)->format('g:i A') }}
                        </div>
                    </div>

                    @if ($class->member->count() > 0)
                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($class->member as $member)
                                    @php
                                        $status = $member->pivot->attendance_status ?? 'not_marked';
                                        $statusClass = '';
                                        $statusIcon = '';

                                        if ($status == 'present') {
                                            $statusClass = 'status-present';
                                            $statusIcon = 'fa-check-circle';
                                        } elseif ($status == 'late') {
                                            $statusClass = 'status-late';
                                            $statusIcon = 'fa-exclamation-circle';
                                        } elseif ($status == 'absent') {
                                            $statusClass = 'status-absent';
                                            $statusIcon = 'fa-times-circle';
                                        } else {
                                            $statusClass = 'status-not-marked';
                                            $statusIcon = 'fa-question-circle';
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="member-info">
                                                <div class="member-avatar">
                                                    @if (!empty($member->photo))
                                                        <img src="{{ asset('admin/uploads/' . $member->photo) }}"
                                                            alt="{{ $member->name }}">
                                                    @else
                                                        <i class="fas fa-user-circle"></i>
                                                    @endif
                                                </div>
                                                <span>{{ $member->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $member->code ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge {{ $statusClass }}">
                                                <i class="fas {{ $statusIcon }}"></i>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($member->pivot->check_in_time)
                                                <span class="check-time">
                                                    <i class="fas fa-sign-in-alt" style="color: var(--success);"></i>
                                                    {{ $member->pivot->check_in_time }}
                                                </span>
                                            @else
                                                <span class="check-time">--:--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($member->pivot->check_out_time)
                                                <span class="check-time">
                                                    <i class="fas fa-sign-out-alt" style="color: var(--danger);"></i>
                                                    {{ $member->pivot->check_out_time }}
                                                </span>
                                            @else
                                                <span class="check-time">--:--</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('attendance.class', $class->id) }}" class="btn-mark">
                                                <i class="fas fa-pen"></i>
                                                Mark
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="padding: 30px; text-align: center; color: var(--gray-light);">
                            <i class="fas fa-info-circle"></i> No members enrolled in this class.
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="no-data">
                <i class="fas fa-calendar-times"></i>
                <p>No classes scheduled for today.</p>
                <a href="{{ route('attendance.calendar') }}" class="btn-mark"
                    style="margin-top: 15px; padding: 10px 20px;">
                    <i class="fas fa-calendar"></i> View Calendar
                </a>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Auto-refresh every 30 seconds for check-in/out updates
            setTimeout(function() {
                location.reload();
            }, 30000);
        });
    </script>
@endsection
