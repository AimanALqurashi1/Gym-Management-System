{{-- resources/views/attendance/calendar.blade.php --}}
@extends('layouts.home')

@section('title', 'Attendance Calendar')

@section('css')
    <style>
        /* Calendar Container - Light Theme */
        .calendar-container {
            padding: 30px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .calendar-header h1 {
            color: var(--dark);
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .calendar-header h1 i {
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .month-nav a {
            color: var(--dark);
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 50px;
            transition: var(--transition);
        }

        .month-nav a:hover {
            background: var(--primary);
            color: white;
        }

        .month-nav span {
            color: var(--dark);
            font-weight: 600;
            font-size: 1.2rem;
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .weekday {
            text-align: center;
            color: var(--primary);
            font-weight: 600;
            padding: 10px;
            font-size: 1rem;
        }

        /* Calendar Day - Light Theme */
        .calendar-day {
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            min-height: 120px;
            padding: 10px;
            transition: var(--transition);
        }

        .calendar-day:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(255, 85, 0, 0.1);
        }

        .calendar-day.today {
            border: 2px solid var(--primary);
            background: rgba(255, 85, 0, 0.05);
        }

        .calendar-day.weekend {
            background: #f5f5f5;
        }

        .day-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .class-indicator {
            font-size: 0.75rem;
            background: var(--primary);
            color: white;
            padding: 2px 6px;
            border-radius: 12px;
        }

        /* Class Item - Light Theme */
        .class-item {
            font-size: 0.8rem;
            padding: 4px 6px;
            margin-bottom: 4px;
            background: rgba(255, 85, 0, 0.08);
            border-left: 2px solid var(--primary);
            border-radius: 3px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .class-item:hover {
            background: rgba(255, 85, 0, 0.15);
            transform: translateX(2px);
            border-left: 3px solid var(--primary);
        }

        .class-item i {
            font-size: 0.7rem;
            margin-right: 3px;
            color: var(--primary);
        }

        .no-classes {
            font-size: 0.75rem;
            color: var(--gray);
            text-align: center;
            padding: 10px 0;
        }

        /* ADDED: Class with payment overdue */
        .class-item.overdue {
            background: rgba(220, 53, 69, 0.08);
            border-left: 2px solid var(--danger);
        }

        .class-item.overdue:hover {
            background: rgba(220, 53, 69, 0.15);
        }

        .class-item.overdue i {
            color: var(--danger);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .calendar-container {
                padding: 20px;
            }

            .calendar-grid {
                grid-template-columns: repeat(1, 1fr);
                gap: 15px;
            }

            .weekday {
                display: none;
            }

            .calendar-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .month-nav {
                width: 100%;
                justify-content: space-between;
            }

            .calendar-day {
                min-height: auto;
            }

            .class-item {
                white-space: normal;
            }
        }

        @media (max-width: 576px) {
            .calendar-container {
                padding: 15px;
            }

            .calendar-grid {
                padding: 15px;
            }

            .month-nav {
                padding: 8px 15px;
            }

            .month-nav span {
                font-size: 1rem;
            }

            .month-nav a {
                padding: 5px 10px;
            }
        }

        /* Animation for calendar days */
        @keyframes fadeInUp {
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
            animation: fadeInUp 0.3s ease forwards;
        }

        .calendar-day:nth-child(1) {
            animation-delay: 0s;
        }

        .calendar-day:nth-child(2) {
            animation-delay: 0.02s;
        }

        .calendar-day:nth-child(3) {
            animation-delay: 0.04s;
        }

        .calendar-day:nth-child(4) {
            animation-delay: 0.06s;
        }

        .calendar-day:nth-child(5) {
            animation-delay: 0.08s;
        }

        .calendar-day:nth-child(6) {
            animation-delay: 0.1s;
        }

        .calendar-day:nth-child(7) {
            animation-delay: 0.12s;
        }

        /* Sunday styling */
        .calendar-day:has(.day-number:contains('Sun')) {
            background: rgba(255, 85, 0, 0.03);
        }

        /* Holiday indicator */
        .holiday-indicator {
            background: rgba(255, 193, 7, 0.1);
            border-left: 2px solid var(--warning);
        }

        .holiday-indicator .day-number {
            color: var(--warning);
        }

        /* Multiple classes indicator */
        .classes-more {
            font-size: 0.7rem;
            color: var(--gray);
            text-align: center;
            margin-top: 4px;
            cursor: pointer;
        }

        .classes-more:hover {
            color: var(--primary);
        }

        /* Tooltip styles for class items */
        .class-item[data-title] {
            position: relative;
        }

        .class-item[data-title]:hover::after {
            content: attr(data-title);
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Loading state for calendar */
        .calendar-loading {
            text-align: center;
            padding: 60px;
            color: var(--gray);
        }

        .calendar-loading i {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary);
        }
    </style>
@endsection

@section('content')
    <div class="calendar-container">
        <div class="calendar-header">
            <h1>
                <i class="fas fa-calendar-alt"></i>
                Attendance Calendar
            </h1>

            <div class="month-nav">
                <a href="{{ route('attendance.calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <span>{{ $startDate->format('F Y') }}</span>
                <a href="{{ route('attendance.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="calendar-grid">
            <div class="weekday">Monday</div>
            <div class="weekday">Tuesday</div>
            <div class="weekday">Wednesday</div>
            <div class="weekday">Thursday</div>
            <div class="weekday">Friday</div>
            <div class="weekday">Saturday</div>
            <div class="weekday">Sunday</div>

            @php
                // Add empty cells for days before month starts
                $firstDayOfWeek = $startDate->dayOfWeek;
                $emptyCells = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;
            @endphp

            @for ($i = 0; $i < $emptyCells; $i++)
                <div class="calendar-day" style="opacity: 0.3;"></div>
            @endfor

            @foreach ($calendar as $day)
                <div class="calendar-day {{ $day['is_today'] ? 'today' : '' }} {{ $day['is_weekend'] ? 'weekend' : '' }}">
                    <div class="day-number">
                        {{ Carbon\Carbon::parse($day['date'])->format('j') }}
                        @if ($day['total_classes'] > 0)
                            <span class="class-indicator">{{ $day['total_classes'] }}</span>
                        @endif
                    </div>

                    @forelse($day['classes'] as $class)
                        <div class="class-item"
                            onclick="window.location.href='{{ route('attendance.class', $class->id) }}'">
                            <i class="fas fa-clock"></i>
                            {{ Carbon\Carbon::parse($class->start_time)->format('g:i A') }} -
                            {{ $class->course->name ?? 'N/A' }}
                        </div>
                    @empty
                        <div class="no-classes">
                            <i class="fas fa-calendar-times"></i> No classes
                        </div>
                    @endforelse
                </div>
            @endforeach
        </div>
    </div>
@endsection
