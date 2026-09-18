{{-- resources/views/member/schedule.blade.php --}}
@extends('layouts.home')

@section('title', 'My Schedule')

@section('css')
    <style>
        /* Schedule Container - Light Theme */
        .schedule-container {
            padding: 30px;
        }

        .schedule-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .schedule-header h1 {
            color: var(--dark);
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .schedule-header h1 i {
            color: var(--primary);
        }

        /* Date Picker - Light Theme */
        .date-picker {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 10px 20px;
            color: var(--dark);
            font-family: 'Open Sans', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .date-picker:hover {
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.1);
        }

        .date-picker:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Week Navigation */
        .week-navigation {
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
        }

        .nav-btn {
            background: transparent;
            border: none;
            color: var(--primary);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-btn:hover {
            background: var(--primary-light);
            transform: scale(1.1);
        }

        .current-week {
            color: var(--dark);
            font-weight: 600;
            min-width: 200px;
            text-align: center;
        }

        /* Week Grid - Light Theme */
        .week-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .weekday {
            text-align: center;
            color: var(--primary);
            font-weight: 700;
            padding: 12px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Day Cards - Light Theme */
        .day-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            min-height: 200px;
            padding: 15px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .day-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .day-card.today {
            border: 2px solid var(--primary);
            background: linear-gradient(135deg, white, var(--primary-light));
            position: relative;
            overflow: hidden;
        }

        .day-card.today::before {
            content: 'TODAY';
            position: absolute;
            top: 10px;
            right: -20px;
            background: var(--primary);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 25px;
            transform: rotate(45deg);
            z-index: 1;
        }

        .day-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .day-number {
            color: var(--dark);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .day-name {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Class Items - Light Theme */
        .class-item {
            background: var(--secondary-light);
            border-left: 3px solid var(--primary);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            transition: var(--transition);
            cursor: pointer;
        }

        .class-item:hover {
            background: var(--primary-light);
            transform: translateX(5px);
        }

        .class-item:last-child {
            margin-bottom: 0;
        }

        .class-time {
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .class-time i {
            font-size: 0.7rem;
        }

        .class-name {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 0.9rem;
        }

        .class-trainer {
            color: var(--gray);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .class-trainer i {
            color: var(--primary);
            font-size: 0.7rem;
        }

        /* Class Status Indicators */
        .class-status {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-scheduled {
            background: var(--success);
            box-shadow: 0 0 5px var(--success);
        }

        .status-completed {
            background: var(--gray);
        }

        .status-cancelled {
            background: var(--danger);
        }

        /* No Class Message */
        .no-class {
            color: var(--gray);
            font-size: 0.85rem;
            text-align: center;
            padding: 30px 10px;
            font-style: italic;
        }

        .no-class i {
            display: block;
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        /* Schedule Legend */
        .schedule-legend {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            justify-content: center;
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
            border-radius: 50%;
        }

        .legend-color.scheduled {
            background: var(--success);
        }

        .legend-color.completed {
            background: var(--gray);
        }

        .legend-color.cancelled {
            background: var(--danger);
        }

        /* Schedule Filters */
        .schedule-filters {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            color: var(--gray);
            margin-bottom: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-select {
            width: 100%;
            padding: 10px 12px;
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--dark);
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        /* View Toggle */
        .view-toggle {
            display: flex;
            gap: 10px;
            background: var(--secondary-light);
            padding: 4px;
            border-radius: 50px;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray);
        }

        .toggle-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 85, 0, 0.2);
        }

        .toggle-btn:hover:not(.active) {
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .week-grid {
                gap: 8px;
            }

            .day-card {
                padding: 10px;
            }
        }

        @media (max-width: 768px) {
            .schedule-container {
                padding: 20px;
            }

            .schedule-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .schedule-header h1 {
                font-size: 1.5rem;
            }

            .week-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .weekday {
                display: none;
            }

            .day-card {
                min-height: auto;
            }

            .day-card.today::before {
                font-size: 0.6rem;
                top: 5px;
                right: -25px;
            }

            .schedule-filters {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .view-toggle {
                width: 100%;
                justify-content: space-between;
            }

            .toggle-btn {
                flex: 1;
                text-align: center;
            }

            .week-navigation {
                width: 100%;
                justify-content: space-between;
            }

            .current-week {
                min-width: auto;
                font-size: 0.9rem;
            }

            .schedule-legend {
                gap: 10px;
            }

            .legend-item {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .schedule-container {
                padding: 15px;
            }

            .schedule-header h1 {
                font-size: 1.3rem;
            }

            .date-picker {
                width: 100%;
                text-align: center;
            }

            .class-item {
                padding: 8px;
            }

            .class-name {
                font-size: 0.85rem;
            }

            .schedule-legend {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .day-card {
            animation: slideIn 0.3s ease forwards;
        }

        /* Loading Skeleton */
        .skeleton-day-card {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: var(--border-radius);
            min-height: 200px;
            padding: 15px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Tooltip */
        .class-item {
            position: relative;
        }

        .class-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
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

            .schedule-header,
            .schedule-filters,
            .week-navigation,
            .view-toggle,
            .schedule-legend {
                display: none;
            }

            .week-grid {
                display: block;
            }

            .day-card {
                break-inside: avoid;
                page-break-inside: avoid;
                margin-bottom: 20px;
            }

            .weekday {
                display: block;
                font-weight: bold;
            }
        }
    </style>
@endsection

@section('content')
    <div class="schedule-container">
        <div class="schedule-header">
            <h1>
                <i class="fas fa-calendar-alt"></i>
                My Schedule
            </h1>
            <div class="date-picker">
                <i class="fas fa-calendar"></i>
                {{ now()->format('F Y') }}
            </div>
        </div>

        <div class="week-grid">
            <div class="weekday">Mon</div>
            <div class="weekday">Tue</div>
            <div class="weekday">Wed</div>
            <div class="weekday">Thu</div>
            <div class="weekday">Fri</div>
            <div class="weekday">Sat</div>
            <div class="weekday">Sun</div>
        </div>

        @php
            $startOfWeek = now()->startOfWeek();
            $days = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $days[] = [
                    'date' => $date,
                    'classes' => $classInstances->get($date->format('Y-m-d'), collect()),
                ];
            }
        @endphp

        <div class="week-grid">
            @foreach ($days as $day)
                <div class="day-card {{ $day['date']->isToday() ? 'today' : '' }}">
                    <div class="day-header">
                        <span class="day-number">{{ $day['date']->format('d') }}</span>
                        <span class="day-name">{{ $day['date']->format('D') }}</span>
                    </div>

                    @if ($day['classes']->count() > 0)
                        @foreach ($day['classes'] as $class)
                            <div class="class-item">
                                <div class="class-time">{{ Carbon\Carbon::parse($class->start_time)->format('g:i A') }}
                                </div>
                                <div class="class-name">{{ $class->course->name ?? 'Class' }}</div>
                                <div class="class-trainer">{{ $class->trainer->name ?? 'Trainer' }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-class">
                            <i class="fas fa-calendar-times"></i>
                            <p>No classes</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
