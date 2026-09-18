{{-- resources/views/member/attendance.blade.php --}}
@extends('layouts.home')

@section('title', 'My Attendance History')

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

        /* Stats Cards - Light Theme */
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
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon.present {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.late {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-icon.absent {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
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

        /* Filter Section - Light Theme */
        .filter-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filter-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            color: var(--gray);
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        .filter-select,
        .filter-input {
            width: 100%;
            padding: 12px 15px;
            background: var(--secondary-light);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition);
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .btn-filter {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            height: 46px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-filter:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.3);
        }

        .btn-reset {
            background: var(--gray);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            height: 46px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-reset:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        /* Attendance Table - Light Theme */
        .attendance-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .attendance-table thead {
            background: var(--primary);
        }

        .attendance-table th {
            color: white;
            font-weight: 700;
            padding: 15px;
            text-align: left;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .attendance-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            vertical-align: middle;
        }

        .attendance-table tbody tr {
            transition: var(--transition);
        }

        .attendance-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Member Cell */
        .member-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
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
            font-size: 1.2rem;
            color: var(--primary);
        }

        .member-info {
            display: flex;
            flex-direction: column;
        }

        .member-name {
            font-weight: 600;
            color: var(--dark);
        }

        .member-code {
            font-size: 0.75rem;
            color: var(--gray);
        }

        /* Status Badges - Light Theme */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
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

        .status-excused {
            background: rgba(23, 162, 184, 0.15);
            color: var(--info);
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        /* Check-in Time */
        .checkin-time {
            font-family: monospace;
            font-weight: 600;
            color: var(--dark);
        }

        .checkin-time i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            background: transparent;
            border: none;
            color: var(--gray);
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1);
        }

        .btn-icon.edit-attendance:hover {
            background: rgba(255, 85, 0, 0.15);
            color: var(--primary);
        }

        /* Chart Container - Light Theme */
        .chart-container {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .chart-container h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .chart-container h3 i {
            color: var(--primary);
        }

        .chart-wrapper {
            height: 300px;
            position: relative;
        }

        /* Summary Cards - Light Theme */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .summary-card {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: var(--transition);
        }

        .summary-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            background: white;
        }

        .summary-value {
            color: var(--dark);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .summary-label {
            color: var(--gray);
            font-size: 0.85rem;
            margin-top: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Export Options - Light Theme */
        .export-options {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-export {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            color: var(--dark);
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
            font-weight: 600;
        }

        .btn-export:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-export i {
            color: var(--primary);
        }

        .btn-export:hover i {
            color: white;
        }

        /* Pagination - Light Theme */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination nav {
            display: inline-block;
        }

        .pagination ul {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
            margin: 0;
        }

        .pagination a,
        .pagination span {
            background: white;
            border: 1px solid var(--border-color);
            color: var(--dark);
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            min-width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .pagination a:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .pagination .active span {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            font-weight: 700;
        }

        .pagination .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray-light);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        /* Date Range Picker */
        .date-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .date-range .filter-group {
            flex: 1;
        }

        .date-separator {
            color: var(--gray);
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .attendance-container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .filter-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filter,
            .btn-reset {
                width: 100%;
                justify-content: center;
            }

            .attendance-table {
                display: block;
                overflow-x: auto;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .export-options {
                flex-direction: column;
            }

            .btn-export {
                justify-content: center;
            }

            .date-range {
                flex-direction: column;
            }

            .chart-wrapper {
                height: 250px;
            }
        }

        @media (max-width: 576px) {
            .attendance-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .member-cell {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons {
                justify-content: center;
            }

            .pagination a,
            .pagination span {
                padding: 6px 10px;
                min-width: 32px;
                height: 32px;
                font-size: 0.8rem;
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

        .stat-card,
        .filter-section,
        .attendance-table,
        .chart-container {
            animation: fadeInUp 0.4s ease forwards;
        }

        /* Loading State */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="attendance-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-clipboard-list"></i>
                My Attendance History
            </h1>
            <div class="export-options">
                <button class="btn-export" onclick="exportAttendance('pdf')">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </button>
                <button class="btn-export" onclick="exportAttendance('csv')">
                    <i class="fas fa-file-csv"></i>
                    CSV
                </button>
            </div>
        </div>

        @php
            // Calculate statistics from the attendance collection
            $totalClasses = $attendance->total();
            $presentCount = $attendance->where('attendance_status', 'present')->count();
            $lateCount = $attendance->where('attendance_status', 'late')->count();
            $absentCount = $attendance->where('attendance_status', 'absent')->count();
            $notMarkedCount = $attendance->whereNull('attendance_status')->count();

            $attendanceRate = $totalClasses > 0 ? round((($presentCount + $lateCount) / $totalClasses) * 100, 2) : 0;
        @endphp

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalClasses }}</h3>
                    <p>Total Classes</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon present">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $presentCount }}</h3>
                    <p>Present</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon late">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $lateCount }}</h3>
                    <p>Late</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon absent">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $absentCount }}</h3>
                    <p>Absent</p>
                </div>
            </div>
        </div>

        <!-- Attendance Rate Card -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-value">{{ $attendanceRate }}%</div>
                <div class="summary-label">Attendance Rate</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $presentCount + $lateCount }}</div>
                <div class="summary-label">Total Attended</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $notMarkedCount }}</div>
                <div class="summary-label">Not Marked</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">
                    @if ($member->schedule()->first())
                        {{ Carbon\Carbon::parse($member->schedule()->first()->pivot->enrolled_date)->format('M Y') }}
                    @else
                        N/A
                    @endif
                </div>
                <div class="summary-label">Member Since</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form action="{{ route('member.attendance') }}" method="GET" class="filter-form" id="filterForm">
                <div class="filter-group">
                    <label>Month</label>
                    <select name="month" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Months</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create()->month($month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Year</label>
                    <select name="year" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Years</option>
                        @for ($year = now()->year; $year >= now()->subYears(2)->year; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Status</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="not_marked" {{ request('status') == 'not_marked' ? 'selected' : '' }}>Not Marked
                        </option>
                    </select>
                </div>

                @if (request()->anyFilled(['month', 'year', 'status']))
                    <a href="{{ route('member.attendance') }}" class="btn-filter" style="background: var(--gray);">
                        <i class="fas fa-undo"></i>
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Attendance Table -->
        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendance as $record)
                    @php
                        $statusClass = '';
                        $statusIcon = '';

                        if ($record->attendance_status == 'present') {
                            $statusClass = 'status-present';
                            $statusIcon = 'fa-check-circle';
                        } elseif ($record->attendance_status == 'late') {
                            $statusClass = 'status-late';
                            $statusIcon = 'fa-exclamation-circle';
                        } elseif ($record->attendance_status == 'absent') {
                            $statusClass = 'status-absent';
                            $statusIcon = 'fa-times-circle';
                        } else {
                            $statusClass = '';
                            $statusIcon = 'fa-question-circle';
                        }
                    @endphp
                    <tr>
                        <td>{{ Carbon\Carbon::parse($record->start_date)->format('M d, Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($record->start_date)->format('l') }}</td>
                        <td>{{ $record->course_name }}</td>
                        <td>{{ $record->trainer_name }}</td>
                        <td>{{ Carbon\Carbon::parse($record->start_time)->format('g:i A') }}</td>
                        <td>
                            @if ($record->attendance_status)
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas {{ $statusIcon }}"></i>
                                    {{ ucfirst($record->attendance_status) }}
                                </span>
                            @else
                                <span class="status-badge">Not Marked</span>
                            @endif
                        </td>
                        <td>{{ $record->check_in_time ?? '--:--' }}</td>
                        <td>{{ $record->check_out_time ?? '--:--' }}</td>
                        <td>
                            @if ($record->duration_minutes)
                                {{ floor($record->duration_minutes / 60) }}h {{ $record->duration_minutes % 60 }}m
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: var(--gray-light);">
                            <i class="fas fa-calendar-times"
                                style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            No attendance records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $attendance->links('pagination::default') }}
        </div>

        <!-- Attendance Tips -->
        <div
            style="background: var(--secondary-light); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 20px; margin-top: 20px;">
            <h3 style="color: white; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-lightbulb" style="color: var(--primary);"></i>
                Attendance Tips
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                <div style="display: flex; align-items: center; gap: 10px; color: var(--gray-light);">
                    <i class="fas fa-clock" style="color: var(--primary);"></i>
                    <span>Check-in opens 15 minutes before class</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: var(--gray-light);">
                    <i class="fas fa-hourglass-half" style="color: var(--primary);"></i>
                    <span>Late check-in within 15 minutes after class start</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: var(--gray-light);">
                    <i class="fas fa-calendar-check" style="color: var(--primary);"></i>
                    <span>Maintain 80% attendance for membership renewal</span>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        function exportAttendance(format) {
            // Get current filters
            const month = document.querySelector('select[name="month"]')?.value || '';
            const year = document.querySelector('select[name="year"]')?.value || '';
            const status = document.querySelector('select[name="status"]')?.value || '';

            // Build URL with filters
            let url = "{{ route('member.attendance.export') }}?format=" + format;
            if (month) url += '&month=' + month;
            if (year) url += '&year=' + year;
            if (status) url += '&status=' + status;

            window.location.href = url;
        }
    </script> --}}
@endsection
