@extends('layouts.home')

@section('title', 'Performance Report - ' . $trainer->name)

@section('css')
    <style>
        /* Report Container - Light Theme */
        .report-container {
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

        /* Header Actions - Light Theme */
        .header-actions {
            display: flex;
            gap: 15px;
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray);
            border: 2px solid var(--border-color);
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Trainer Header - Light Theme */
        .trainer-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .trainer-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .trainer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .trainer-avatar i {
            font-size: 2.5rem;
            color: white;
        }

        .trainer-info h2 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .trainer-info p {
            color: var(--gray);
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .trainer-info p i {
            color: var(--primary);
        }

        /* Date Range - Light Theme */
        .date-range {
            margin-left: auto;
            color: var(--dark);
            background: #f5f5f5;
            padding: 10px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border-color);
        }

        .date-range i {
            color: var(--primary);
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
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-value {
            color: var(--dark);
            font-size: 2.5rem;
            font-weight: 700;
        }

        .stat-label {
            color: var(--gray);
            margin-top: 5px;
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
        }

        .chart-container h3 i {
            color: var(--primary);
        }

        /* Data Grid - Light Theme */
        .data-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .data-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .data-card h3 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .data-card h3 i {
            color: var(--primary);
        }

        /* Course Breakdown Table - Light Theme */
        .course-breakdown {
            width: 100%;
            border-collapse: collapse;
        }

        .course-breakdown th {
            text-align: left;
            padding: 10px;
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .course-breakdown td {
            padding: 10px;
            color: var(--dark);
            border-top: 1px solid var(--border-color);
        }

        .course-breakdown tbody tr:hover {
            background: var(--primary-light);
        }

        /* Trend Items - Light Theme */
        .trend-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .trend-item:hover {
            background: var(--primary-light);
            padding-left: 8px;
            border-radius: 8px;
        }

        .trend-item:last-child {
            border-bottom: none;
        }

        .trend-date {
            color: var(--dark);
            font-weight: 500;
        }

        .trend-stats {
            display: flex;
            gap: 20px;
            color: var(--gray);
        }

        .trend-stats span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .trend-stats i {
            color: var(--primary);
        }

        /* Badge - Light Theme */
        .badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        /* ADDED: Class List Table */
        .class-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .class-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .class-table td {
            padding: 12px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
        }

        .class-table tbody tr:hover {
            background: var(--primary-light);
        }

        .class-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ADDED: Performance Summary */
        .performance-summary {
            background: #fafafa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
        }

        .performance-summary h3 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .performance-summary h3 i {
            color: var(--primary);
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .summary-stat {
            text-align: center;
        }

        .summary-stat .value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .summary-stat .label {
            color: var(--gray);
            font-size: 0.85rem;
        }

        /* Export Options - Light Theme */
        .export-options {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-export {
            background: #f5f5f5;
            border: 1px solid var(--border-color);
            color: var(--dark);
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-export:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .data-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .summary-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .report-container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .trainer-header {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .trainer-info h2 {
                font-size: 1.5rem;
            }

            .trainer-info p {
                justify-content: center;
            }

            .date-range {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-value {
                font-size: 1.8rem;
            }

            .trend-item {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .trend-stats {
                justify-content: center;
            }

            .course-breakdown,
            .class-table {
                display: block;
                overflow-x: auto;
            }

            .export-options {
                flex-direction: column;
            }

            .btn-export {
                width: 100%;
                justify-content: center;
            }

            .summary-stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .report-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .trainer-avatar {
                width: 60px;
                height: 60px;
            }

            .trainer-avatar i {
                font-size: 1.8rem;
            }

            .trainer-info h2 {
                font-size: 1.2rem;
            }

            .course-breakdown th,
            .course-breakdown td,
            .class-table th,
            .class-table td {
                padding: 8px;
                font-size: 0.8rem;
            }

            .trend-stats {
                flex-direction: column;
                gap: 5px;
            }
        }

        /* Animation */
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
        .chart-container,
        .data-card {
            animation: fadeInUp 0.3s ease forwards;
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
    </style>
@endsection

@section('content')
    <div class="report-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-chart-line"></i>
                Trainer Performance Report
            </h1>
            <div class="header-actions">
                <a href="{{ route('reports.trainer.performance') }}" class="btn-secondary">
                    <i class="fas fa-user-tie"></i>
                    Change Trainer
                </a>
                <a href="{{ route('reports.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Reports
                </a>
            </div>
        </div>

        <!-- Trainer Header -->
        <div class="trainer-header">
            <div class="trainer-avatar">
                @if (!empty($trainer->photo))
                    <img src="{{ asset('admin/uploads/' . $trainer->photo) }}" alt="{{ $trainer->name }}">
                @else
                    <i class="fas fa-user-tie"></i>
                @endif
            </div>
            <div class="trainer-info">
                <h2>{{ $trainer->name }}</h2>
                <p><i class="fas fa-id-card"></i> Code: {{ $trainer->code ?? 'N/A' }}</p>
                <p><i class="fas fa-dumbbell"></i> Specialization: {{ $trainer->specialization ?? 'General' }}</p>
                <p><i class="fas fa-phone"></i> {{ $trainer->phone ?? 'No Phone' }}</p>
            </div>
            <div class="date-range">
                <i class="fas fa-calendar"></i>
                {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_classes'] }}</div>
                <div class="stat-label">Total Classes</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_member_slots'] }}</div>
                <div class="stat-label">Total Member Slots</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_attendance'] }}</div>
                <div class="stat-label">Total Attendance</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['avg_class_size'] }}</div>
                <div class="stat-label">Avg Class Size</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['avg_attendance_rate'] }}%</div>
                <div class="stat-label">Avg Attendance Rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['unique_courses'] }}</div>
                <div class="stat-label">Courses Taught</div>
            </div>
        </div>

        <!-- Daily Trend Chart -->
        <div class="chart-container">
            <h3><i class="fas fa-chart-line"></i> Daily Class Trend</h3>
            <canvas id="dailyTrendChart" style="width: 100%; height: 300px;"></canvas>
        </div>

        <!-- Data Grid -->
        <div class="data-grid">
            <!-- Course Breakdown -->
            <div class="data-card">
                <h3><i class="fas fa-book-open"></i> Course Breakdown</h3>
                <table class="course-breakdown">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Classes</th>
                            <th>Members</th>
                            <th>Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseBreakdown as $course)
                            <tr>
                                <td>{{ $course['course_name'] }}</td>
                                <td>{{ $course['class_count'] }}</td>
                                <td>{{ $course['total_members'] }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $course['attendance_rate'] }}%</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Daily Performance -->
            <div class="data-card">
                <h3><i class="fas fa-calendar-day"></i> Daily Performance</h3>
                @foreach ($dailyTrend as $day)
                    <div class="trend-item">
                        <span class="trend-date">{{ \Carbon\Carbon::parse($day['date'])->format('M d, Y') }}</span>
                        <div class="trend-stats">
                            <span><i class="fas fa-clock"></i> {{ $day['count'] }} classes</span>
                            <span><i class="fas fa-users"></i> {{ $day['members'] }} members</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Classes List -->
        <h3 style="color: white; margin-bottom: 20px;">Class Details</h3>

        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Course</th>
                    <th>Time</th>
                    <th>Total Spots</th>
                    <th>Enrolled</th>
                    <th>Present</th>
                    <th>Attendance %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    @php
                        $enrolled = $class->member->count();
                        $present = $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();
                        $attendanceRate = $enrolled > 0 ? round(($present / $enrolled) * 100, 2) : 0;
                    @endphp
                    <tr>
                        <td>{{ $class->start_date->format('M d, Y') }}</td>
                        <td>{{ $class->course->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }}</td>
                        <td>{{ $class->total_spots }}</td>
                        <td>{{ $enrolled }}</td>
                        <td>{{ $present }}</td>
                        <td>
                            <span class="badge badge-success">{{ $attendanceRate }}%</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--gray-light);">
                            <i class="fas fa-calendar-times"></i>
                            No classes found for this period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Export Options -->
        <div class="export-options">
            <button class="btn-export" onclick="exportReport('pdf')">
                <i class="fas fa-file-pdf"></i>
                Export PDF
            </button>
            <button class="btn-export" onclick="exportReport('excel')">
                <i class="fas fa-file-excel"></i>
                Export Excel
            </button>
            <button class="btn-export" onclick="exportReport('csv')">
                <i class="fas fa-file-csv"></i>
                Export CSV
            </button>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('dailyTrendChart').getContext('2d');

        const dailyData = @json($dailyTrend);

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dailyData.map(d => new Date(d.date).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                })),
                datasets: [{
                        label: 'Classes',
                        data: dailyData.map(d => d.count),
                        backgroundColor: 'rgba(255, 85, 0, 0.7)',
                        borderColor: '#ff5500',
                        borderWidth: 1
                    },
                    {
                        label: 'Members',
                        data: dailyData.map(d => d.members),
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: '#28a745',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#aaa',
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#aaa'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });

        function exportReport(format) {
            const data = {
                trainer: {
                    id: '{{ $trainer->id }}',
                    name: '{{ $trainer->name }}',
                    code: '{{ $trainer->code }}',
                    specialization: '{{ $trainer->specialization }}'
                },
                date_range: {
                    start: '{{ $startDate->format('Y-m-d') }}',
                    end: '{{ $endDate->format('Y-m-d') }}'
                },
                stats: @json($stats),
                classes: @json($classes)
            };

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('reports.export') }}';

            form.innerHTML = `
            @csrf
            <input type="hidden" name="type" value="trainer">
            <input type="hidden" name="format" value="${format}">
            <input type="hidden" name="data" value='${JSON.stringify(data)}'>
        `;

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
