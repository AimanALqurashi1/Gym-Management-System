{{-- resources/views/trainer/schedule.blade.php --}}
@extends('layouts.home')

@section('title', 'My Schedule')

@section('css')
    <style>
        /* Schedule Container - Light Theme */
        .schedule-container {
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

        /* Month Navigation - Light Theme */
        .month-nav {
            display: flex;
            align-items: center;
            gap: 20px;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .month-nav a {
            color: var(--dark);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 50px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        .month-nav a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .month-nav a i {
            font-size: 0.9rem;
        }

        .month-nav span {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* View Toggle Buttons */
        .view-toggle {
            display: flex;
            gap: 10px;
            background: white;
            padding: 5px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
        }

        .view-btn {
            background: transparent;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .view-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 85, 0, 0.2);
        }

        .view-btn:hover:not(.active) {
            color: var(--primary);
        }

        /* Calendar Grid - Light Theme */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .weekday {
            text-align: center;
            color: var(--primary);
            font-weight: 700;
            padding: 12px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Calendar Day - Light Theme */
        .calendar-day {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            min-height: 130px;
            padding: 10px;
            transition: var(--transition);
            position: relative;
        }

        .calendar-day:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .calendar-day.has-class {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .calendar-day.other-month {
            opacity: 0.5;
        }

        .calendar-day.today {
            border: 2px solid var(--primary);
            background: linear-gradient(135deg, white, var(--primary-light));
            position: relative;
        }

        .calendar-day.today::before {
            content: 'TODAY';
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--primary);
            color: white;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .day-number {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .class-indicator {
            font-size: 0.7rem;
            background: var(--primary);
            color: white;
            padding: 2px 6px;
            border-radius: 12px;
            font-weight: 600;
        }

        .day-classes {
            display: flex;
            flex-direction: column;
            gap: 5px;
            max-height: 80px;
            overflow-y: auto;
        }

        .day-class {
            font-size: 0.7rem;
            padding: 5px 8px;
            background: white;
            border-left: 3px solid var(--primary);
            border-radius: 5px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-weight: 500;
        }

        .day-class:hover {
            background: var(--primary);
            color: white;
            transform: translateX(3px);
        }

        .day-class .class-time {
            font-size: 0.65rem;
            opacity: 0.8;
        }

        /* Class List Section - Light Theme */
        .class-list {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .class-list h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-primary);
        }

        .class-list h3 i {
            color: var(--primary);
        }

        /* Class Table - Light Theme */
        .class-table {
            width: 100%;
            border-collapse: collapse;
        }

        .class-table thead {
            background: var(--primary);
        }

        .class-table th {
            text-align: left;
            padding: 12px 15px;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .class-table td {
            padding: 12px 15px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
        }

        .class-table tbody tr {
            transition: var(--transition);
        }

        .class-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Class Info Cell */
        .class-info-cell {
            display: flex;
            flex-direction: column;
        }

        .class-name {
            font-weight: 600;
            color: var(--dark);
        }

        .class-trainer {
            font-size: 0.75rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 3px;
        }

        .class-trainer i {
            color: var(--primary);
        }

        /* Time Cell */
        .time-cell {
            font-family: monospace;
            font-weight: 600;
            color: var(--primary);
        }

        /* Location Cell */
        .location-cell {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .location-cell i {
            color: var(--primary);
        }

        /* Status Badge */
        .class-status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-scheduled {
            background: rgba(23, 162, 184, 0.15);
            color: var(--info);
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-cancelled {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* View Button */
        .btn-view {
            background: var(--primary);
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        /* Schedule Legend */
        .schedule-legend {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            padding: 15px 20px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray);
            font-size: 0.8rem;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .legend-color.scheduled {
            background: var(--info);
        }

        .legend-color.completed {
            background: var(--success);
        }

        .legend-color.cancelled {
            background: var(--danger);
        }

        .legend-color.has-class {
            background: var(--primary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .schedule-container {
                padding: 20px;
            }

            .calendar-grid {
                gap: 8px;
                padding: 15px;
            }

            .calendar-day {
                min-height: 100px;
            }
        }

        @media (max-width: 768px) {
            .schedule-container {
                padding: 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .month-nav {
                width: 100%;
                justify-content: space-between;
            }

            .month-nav span {
                font-size: 1rem;
            }

            .month-nav a {
                padding: 5px 12px;
            }

            .view-toggle {
                width: 100%;
                justify-content: space-between;
            }

            .view-btn {
                flex: 1;
                text-align: center;
            }

            .calendar-grid {
                overflow-x: auto;
                display: block;
            }

            .calendar-grid .weekday,
            .calendar-grid .calendar-day {
                display: none;
            }

            /* Mobile calendar view as list */
            .mobile-calendar-view {
                display: block;
            }

            .class-table {
                display: block;
                overflow-x: auto;
            }

            .class-table th,
            .class-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .schedule-legend {
                gap: 12px;
            }

            .legend-item {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .schedule-container {
                padding: 10px;
            }

            .month-nav {
                padding: 8px 12px;
            }

            .month-nav span {
                font-size: 0.9rem;
            }

            .month-nav a {
                padding: 4px 10px;
                font-size: 0.85rem;
            }

            .calendar-grid {
                padding: 10px;
            }

            .class-list {
                padding: 15px;
            }

            .class-list h3 {
                font-size: 1rem;
            }

            .btn-view {
                padding: 4px 10px;
                font-size: 0.75rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .calendar-day {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Loading Skeleton */
        .skeleton-calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            padding: 20px;
        }

        .skeleton-day {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 10px;
            min-height: 120px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Scrollbar for day classes */
        .day-classes::-webkit-scrollbar {
            width: 3px;
        }

        .day-classes::-webkit-scrollbar-track {
            background: var(--secondary-light);
            border-radius: 3px;
        }

        .day-classes::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        /* Tooltip on hover */
        .day-class {
            position: relative;
        }

        .day-class:hover::after {
            content: attr(data-full);
            position: absolute;
            bottom: 100%;
            left: 0;
            background: var(--dark);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 5px;
        }

        /* Print Styles */
        @media print {

            .month-nav,
            .view-toggle,
            .schedule-legend {
                display: none;
            }

            .calendar-grid {
                border: 1px solid #ddd;
            }

            .calendar-day {
                border: 1px solid #ddd;
                background: white;
            }

            .day-number {
                color: black;
            }
        }
    </style>
@endsection

@section('content')
    <div class="schedule-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-calendar-alt"></i>
                My Schedule
            </h1>

            <div class="month-nav">
                <a
                    href="{{ route('trainer.schedule', ['month' => $startDate->copy()->subMonth()->month, 'year' => $startDate->copy()->subMonth()->year]) }}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <span>{{ $startDate->format('F Y') }}</span>
                <a
                    href="{{ route('trainer.schedule', ['month' => $startDate->copy()->addMonth()->month, 'year' => $startDate->copy()->addMonth()->year]) }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="calendar-grid">
            <div class="weekday">Mon</div>
            <div class="weekday">Tue</div>
            <div class="weekday">Wed</div>
            <div class="weekday">Thu</div>
            <div class="weekday">Fri</div>
            <div class="weekday">Sat</div>
            <div class="weekday">Sun</div>

            @php
                $firstDayOfWeek = $startDate->copy()->startOfMonth()->dayOfWeek;
                $emptyCells = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;
                $currentDate = $startDate->copy()->startOfMonth();
            @endphp

            @for ($i = 0; $i < $emptyCells; $i++)
                <div class="calendar-day" style="opacity: 0.3;"></div>
            @endfor

            @while ($currentDate->lte($endDate))
                @php
                    $dateKey = $currentDate->format('Y-m-d');
                    $dayClasses = $classes[$dateKey] ?? collect();
                    $hasClass = $dayClasses->count() > 0;
                @endphp

                <div class="calendar-day {{ $hasClass ? 'has-class' : '' }}">
                    <div class="day-number">
                        {{ $currentDate->format('j') }}
                        @if ($hasClass)
                            <span class="class-indicator">{{ $dayClasses->count() }}</span>
                        @endif
                    </div>
                    @if ($hasClass)
                        <div class="day-classes">
                            @foreach ($dayClasses->take(2) as $class)
                                <div class="day-class"
                                    onclick="window.location.href='{{ route('trainer.class.details', $class->id) }}'">
                                    {{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} -
                                    {{ $class->course->name ?? 'Class' }}
                                </div>
                            @endforeach
                            @if ($dayClasses->count() > 2)
                                <div class="day-class">+{{ $dayClasses->count() - 2 }} more</div>
                            @endif
                        </div>
                    @endif
                </div>

                @php $currentDate->addDay(); @endphp
            @endwhile
        </div>

        <!-- List View for the Month -->
        <div class="class-list">
            <h3><i class="fas fa-list"></i> All Classes This Month</h3>

            @if ($classes->isNotEmpty())
                <table class="class-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Course</th>
                            <th>Members</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $date => $dayClasses)
                            @foreach ($dayClasses as $class)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}</td>
                                    <td>{{ $class->course->name ?? 'N/A' }}</td>
                                    <td>{{ $class->member->count() }}/{{ $class->total_spots }}</td>
                                    <td>
                                        @php
                                            $today = now()->format('Y-m-d');
                                            if ($class->start_date->format('Y-m-d') < $today) {
                                                echo '<span style="color: var(--gray-light);">Completed</span>';
                                            } elseif ($class->start_date->format('Y-m-d') == $today) {
                                                echo '<span style="color: var(--primary);">Today</span>';
                                            } else {
                                                echo '<span style="color: var(--success);">Upcoming</span>';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <a href="{{ route('trainer.class.details', $class->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: var(--gray-light); text-align: center; padding: 40px;">
                    <i class="fas fa-calendar-times"></i> No classes scheduled for this month
                </p>
            @endif
        </div>
    </div>
@endsection
