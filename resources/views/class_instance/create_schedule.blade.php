@extends('layouts.home')

@section('css')
    <style>
        /* Schedule specific styles that inherit from your dashboard */
        .schedule-cell {
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            height: 60px;
            vertical-align: middle;
        }

        .schedule-cell:hover {
            background: var(--primary-light) !important;
            transform: scale(1.02);
            box-shadow: var(--shadow-hover);
        }

        .schedule-cell:empty::before {
            content: '+ Click to add class';
            color: var(--gray-light);
            font-size: 0.8rem;
            opacity: 0.7;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .schedule-cell:not(:empty) {
            background: rgba(255, 85, 0, 0.15);
            color: var(--light);
            font-weight: 500;
            text-align: center;
        }

        .schedule-cell.has-class {
            background: rgba(40, 167, 69, 0.15);

            border-left: 3px solid var(--success);
        }

        .data-table td {
            vertical-align: middle;
            padding: 12px 10px;
        }

        .data-table tbody tr:hover {
            background: transparent;
        }

        .data-table tbody tr:not(:has(td[colspan])):hover {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Time slot info in cells */
        .schedule-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .schedule-info .class-name {
            font-weight: 600;
            color: black;
        }

        .schedule-info .class-details {
            font-size: 0.7rem;
            color: black;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-content">
        <!-- Schedule Header -->
        <div class="section-header">
            <h2><i class="fas fa-calendar-alt"></i> Weekly Class Schedule</h2>
            <div class="top-bar-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search schedule...">
                </div>
                <button class="btn btn-primary btn-sm" onclick="exportSchedule()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Schedule Stats -->
        <div class="stats-container" style="grid-template-columns: repeat(5, 1fr);">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>8 AM</h3>
                    <p>Start Time</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>7:30 PM</h3>
                    <p>End Time</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-info">
                    <h3>5</h3>
                    <p>Daily Classes</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-info">
                    <h3>1.5h</h3>
                    <p>Per Class</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-info">
                    <h3>12-2 PM</h3>
                    <p>Lunch Break</p>
                </div>
            </div>
        </div>

        <!-- Schedule Table -->
        <div class="content-card" style="padding: 20px; overflow-x: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="display: flex; gap: 15px;">
                    <span class="status-badge status-active">
                        <i class="fas fa-circle" style="font-size: 0.6rem; margin-right: 5px;"></i> Available slots
                    </span>
                    <span class="status-badge" style="background: rgba(255, 85, 0, 0.2); color: var(--primary);">
                        <i class="fas fa-utensils" style="margin-right: 5px;"></i> Lunch break
                    </span>
                </div>
                <span class="status-badge" style="background: var(--primary-light); color: var(--light);">
                    <i class="fas fa-calendar-week"></i> Week 1 • 5 Classes Daily
                </span>
            </div>

            <table class="data-table" style="min-width: 1000px;">
                <thead>
                    <tr>
                        <th style="width: 120px;">Time</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $scheduleMap = [];

                        foreach ($existingSchedules ?? [] as $schedule) {
                            $scheduleMap[strtolower($schedule->day_of_week)][
                                \Carbon\Carbon::parse($schedule->start_time)->format('H:i')
                            ] = $schedule;
                        }
                    @endphp
                    <!-- Class 1 -->
                    <tr>
                        <td style="background: rgba(255,85,0,0.1); font-weight: 600;">
                            <div>8:00 - 9:30</div>
                            <small style="color: var(--gray-light);">Class 1</small>
                        </td>
                        <!-- monday -->
                        @php
                            $day = 'monday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="monday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- tuesday -->
                        @php
                            $day = 'tuesday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="tuesday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- wednesday -->
                        @php
                            $day = 'wednesday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="wednesday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- thursday -->
                        @php
                            $day = 'thursday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="thursday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- friday -->
                        @php
                            $day = 'friday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="friday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- saturday -->
                        @php
                            $day = 'saturday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="saturday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- sunday -->
                        @php
                            $day = 'sunday';
                            $time = '08:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="09:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="sunday" data-start="08:00" data-end="09:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                    </tr>
                    <!-- Break -->
                    <tr style="background: rgba(255,255,255,0.02);">
                        <td style="color: var(--gray-light); font-size: 0.9rem;">
                            <i class="fas fa-coffee"></i> 30m break
                        </td>
                        <td colspan="7" style="color: var(--gray-light); font-size: 0.9rem; text-align: center;">
                            <i class="fas fa-hourglass-start"></i> Break between classes
                        </td>
                    </tr>
                    <!-- Class 2 -->
                    <tr>
                        <td style="background: rgba(255,85,0,0.1); font-weight: 600;">
                            <div>10:00 - 11:30</div>
                            <small style="color: var(--gray-light);">Class 2</small>
                        </td>
                        <!-- monday -->
                        @php
                            $day = 'monday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="monday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- tuesday -->
                        @php
                            $day = 'tuesday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="tuesday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- wednesday -->
                        @php
                            $day = 'wednesday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="wednesday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- thursday -->
                        @php
                            $day = 'thursday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="thursday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- friday -->
                        @php
                            $day = 'friday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="friday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- saturday -->
                        @php
                            $day = 'saturday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="saturday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- sunday -->
                        @php
                            $day = 'sunday';
                            $time = '10:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="11:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="sunday" data-start="10:00" data-end="11:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                    </tr>
                    <!-- LUNCH BREAK -->
                    <tr style="background: rgba(255, 85, 0, 0.15); border-left: 4px solid var(--primary);">
                        <td style="color: var(--primary); font-weight: 700;">
                            <i class="fas fa-utensils"></i> 12:00 - 2:00
                        </td>
                        <td colspan="7" style="text-align: center; color: var(--primary); font-weight: 600;">
                            <i class="fas fa-clock"></i> LUNCH BREAK - NO CLASSES
                        </td>
                    </tr>
                    <!-- Class 3 -->
                    <tr>
                        <td style="background: rgba(255,85,0,0.1); font-weight: 600;">
                            <div>2:00 - 3:30</div>
                            <small style="color: var(--gray-light);">Class 3</small>
                        </td>
                        <!-- monday -->
                        @php
                            $day = 'monday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="monday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- tuesday -->
                        @php
                            $day = 'tuesday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="tuesday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- wednesday -->
                        @php
                            $day = 'wednesday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="wednesday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- thursday -->
                        @php
                            $day = 'thursday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="thursday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- friday -->
                        @php
                            $day = 'friday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="friday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- saturday -->
                        @php
                            $day = 'saturday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}" data-day="{{ $day }}"
                                data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="saturday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- sunday -->
                        @php
                            $day = 'sunday';
                            $time = '14:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="15:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="sunday" data-start="14:00" data-end="15:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                    </tr>
                    <!-- Break -->
                    <tr style="background: rgba(255,255,255,0.02);">
                        <td style="color: var(--gray-light); font-size: 0.9rem;">
                            <i class="fas fa-coffee"></i> 30m break
                        </td>
                        <td colspan="7" style="color: var(--gray-light); font-size: 0.9rem; text-align: center;">
                            <i class="fas fa-hourglass-start"></i> Break between classes
                        </td>
                    </tr>
                    <!-- Class 4 -->
                    <tr>
                        <td style="background: rgba(255,85,0,0.1); font-weight: 600;">
                            <div>4:00 - 5:30</div>
                            <small style="color: var(--gray-light);">Class 4</small>
                        </td>
                        <!-- monday -->
                        @php
                            $day = 'monday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="monday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- tuesday -->
                        @php
                            $day = 'tuesday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="tuesday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- wednesday -->
                        @php
                            $day = 'wednesday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="wednesday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- thursday -->
                        @php
                            $day = 'thursday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="thursday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- friday -->
                        @php
                            $day = 'friday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="friday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- saturday -->
                        @php
                            $day = 'saturday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="saturday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- sunday -->
                        @php
                            $day = 'sunday';
                            $time = '16:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="17:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="sunday" data-start="16:00" data-end="17:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                    </tr>
                    <!-- Break -->
                    <tr style="background: rgba(255,255,255,0.02);">
                        <td style="color: var(--gray-light); font-size: 0.9rem;">
                            <i class="fas fa-coffee"></i> 30m break
                        </td>
                        <td colspan="7" style="color: var(--gray-light); font-size: 0.9rem; text-align: center;">
                            <i class="fas fa-hourglass-start"></i> Break between classes
                        </td>
                    </tr>
                    <!-- Class 5 -->
                    <tr>
                        <td style="background: rgba(255,85,0,0.1); font-weight: 600;">
                            <div>6:00 - 7:30</div>
                            <small style="color: var(--gray-light);">Class 5</small>
                        </td>
                        <!-- monday -->
                        @php
                            $day = 'monday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="monday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- tuesday -->
                        @php
                            $day = 'tuesday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="tuesday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- wednesday -->
                        @php
                            $day = 'wednesday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="wednesday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- thursday -->
                        @php
                            $day = 'thursday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="thursday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                        <!-- friday -->
                        @php
                            $day = 'friday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">


                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="friday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- saturday -->
                        @php
                            $day = 'saturday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="saturday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif
                        <!-- sunday -->
                        @php
                            $day = 'sunday';
                            $time = '18:00';
                            $schedule = $scheduleMap[$day][$time] ?? null;
                        @endphp
                        @if ($schedule)
                            <td class="schedule-cell {{ $schedule ? 'has-class' : '' }}"
                                data-day="{{ $day }}" data-start="{{ $time }}" data-end="19:30">
                                <div class="schedule-info">
                                    <div class="class-name">
                                        Trainer : {{ $schedule->trainer->name }}
                                    </div>
                                    <div class="class-details">
                                        {{ $schedule->course->name }}
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="schedule-cell" data-day="sunday" data-start="18:00" data-end="19:30"
                                onclick="handleScheduleClick(this)"></td>
                        @endif

                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions" style="margin-top: 30px;">
            <div class="action-card" onclick="bulkAdd()">
                <i class="fas fa-layer-group"></i>
                <h3>Bulk Add</h3>
                <p>Add classes to multiple slots</p>
            </div>
            <div class="action-card" onclick="clearAll()">
                <i class="fas fa-eraser"></i>
                <h3>Clear All</h3>
                <p>Reset schedule</p>
            </div>
            <div class="action-card" onclick="exportSchedule()">
                <i class="fas fa-file-export"></i>
                <h3>Export</h3>
                <p>Download as CSV</p>
            </div>
            <div class="action-card" onclick="printSchedule()">
                <i class="fas fa-print"></i>
                <h3>Print</h3>
                <p>Print schedule</p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Get member, trainer, class data from the server
        // These should be passed from your controller
        const memberData = {!! json_encode($member ?? null) !!};
        const trainerData = {!! json_encode($trainer ?? null) !!};
        const courseData = {!! json_encode($course ?? null) !!};

        function handleScheduleClick(cell) {
            // Get data from the cell
            const day = cell.dataset.day;
            const startTime = cell.dataset.start;
            const endTime = cell.dataset.end;

            // Calculate date for the next occurrence of this day
            const nextDate = getNextDayDate(day);

            // Build URL with query parameters
            let url = '{{ route('classInstance.createClassInstance') }}?';

            // Add time slot data
            url += 'day=' + encodeURIComponent(day);
            url += '&start_time=' + encodeURIComponent(startTime);
            url += '&end_time=' + encodeURIComponent(endTime);
            url += '&date=' + encodeURIComponent(nextDate);

            // Add member, trainer, class data if available
            if (memberData && memberData.id) {
                url += '&member_id=' + encodeURIComponent(memberData.id);
            }
            if (trainerData && trainerData.id) {
                url += '&trainer_id=' + encodeURIComponent(trainerData.id);
            }
            if (courseData && courseData.id) {
                url += '&course_id=' + encodeURIComponent(courseData.id);
            }

            // Redirect to create page
            window.location.href = url;
        }

        function getNextDayDate(dayName) {
            const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            const targetDayIndex = days.indexOf(dayName.toLowerCase());

            const today = new Date();
            const todayDayIndex = today.getDay(); // 0 = Sunday, 1 = Monday, etc.

            let daysToAdd = targetDayIndex - todayDayIndex;
            if (daysToAdd < 0) {
                daysToAdd += 7; // Next week
            }

            const nextDate = new Date(today);
            nextDate.setDate(today.getDate() + daysToAdd);

            // Format as YYYY-MM-DD
            return nextDate.toISOString().split('T')[0];
        }

        function bulkAdd() {
            alert('Bulk add feature - Would open modal with your dashboard modal style');
        }

        function clearAll() {
            if (confirm('Clear all schedule data?')) {
                document.querySelectorAll('.schedule-cell').forEach(cell => {
                    cell.innerHTML = '';
                    cell.classList.remove('has-class');
                });
            }
        }

        function exportSchedule() {
            let csv = 'Day,Time,Class\n';

            document.querySelectorAll('.schedule-cell:not(:empty)').forEach(cell => {
                const day = cell.dataset.day;
                const startTime = cell.dataset.start;
                const endTime = cell.dataset.end;
                const className = cell.querySelector('.class-name')?.textContent || 'Scheduled Class';

                csv += `${day},${startTime}-${endTime},${className}\n`;
            });

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'schedule.csv';
            a.click();
        }

        function printSchedule() {
            window.print();
        }
    </script>
@endsection
