{{-- resources/views/reports/member/attendance.blade.php --}}
@extends('layouts.home')

@section('title', 'Attendance Report - ' . $member->name)

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

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Member Header - Light Theme */
        .member-header {
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

        .member-avatar {
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

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar i {
            font-size: 2.5rem;
            color: white;
        }

        .member-info h2 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .member-info p {
            color: var(--gray);
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .member-info p i {
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

        /* Progress Bar - Light Theme */
        .progress-bar {
            width: 100%;
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            margin: 15px 0 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--success);
            border-radius: 5px;
            transition: width 0.3s ease;
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

        /* ADDED: Payment Information Section */
        .payment-info-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .payment-status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .payment-status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .payment-status-partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .payment-status-pending {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .payment-status-overdue {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .payment-details {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .payment-detail {
            text-align: center;
        }

        .payment-detail .label {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .payment-detail .value {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Attendance Table - Light Theme */
        .attendance-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .attendance-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .attendance-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
        }

        .attendance-table tbody tr:hover {
            background: var(--primary-light);
        }

        .attendance-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badge - Light Theme */
        .status-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
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
        @media (max-width: 768px) {
            .report-container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .member-header {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .member-info h2 {
                font-size: 1.5rem;
            }

            .member-info p {
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

            .payment-info-section {
                flex-direction: column;
                text-align: center;
            }

            .payment-details {
                justify-content: center;
            }

            .attendance-table {
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

            .member-avatar {
                width: 60px;
                height: 60px;
            }

            .member-avatar i {
                font-size: 1.8rem;
            }

            .member-info h2 {
                font-size: 1.2rem;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .payment-details {
                gap: 15px;
            }

            .payment-detail .value {
                font-size: 1rem;
            }
        }

        /* Animation for table rows */
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

        .attendance-table tbody tr {
            animation: fadeIn 0.2s ease forwards;
        }

        /* Loading state */
        .loading {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }

        .loading i {
            font-size: 2rem;
            color: var(--primary);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="report-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-calendar-check"></i>
                Member Attendance Report
            </h1>
            <div class="header-actions">
                <a href="{{ route('reports.member.attendance') }}" class="btn-secondary">
                    <i class="fas fa-user"></i>
                    Change Member
                </a>
                <a href="{{ route('reports.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Reports
                </a>
            </div>
        </div>

        <!-- Member Header -->
        <div class="member-header">
            <div class="member-avatar">
                @if (!empty($member->photo))
                    <img src="{{ asset('admin/uploads/' . $member->photo) }}" alt="{{ $member->name }}">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
            </div>
            <div class="member-info">
                <h2>{{ $member->name }}</h2>
                <p><i class="fas fa-id-card"></i> Code: {{ $member->code ?? 'N/A' }}</p>
                <p><i class="fas fa-envelope"></i> {{ $member->email ?? 'No Email' }}</p>
                <p><i class="fas fa-phone"></i> {{ $member->phone ?? 'No Phone' }}</p>
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
                <div class="stat-value" style="color: var(--success);">{{ $stats['present'] }}</div>
                <div class="stat-label">Present</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--warning);">{{ $stats['late'] ?? 0 }}</div>
                <div class="stat-label">Late</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--danger);">{{ $stats['absent'] }}</div>
                <div class="stat-label">Absent</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['attendance_rate'] }}%</div>
                <div class="stat-label">Attendance Rate</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stats['attendance_rate'] }}%;"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ floor($stats['total_minutes'] / 60) }}h {{ $stats['total_minutes'] % 60 }}m
                </div>
                <div class="stat-label">Total Time</div>
            </div>
        </div>

        <!-- Monthly Trend Chart -->
        @if ($monthlyTrend->count() > 0)
            <div class="chart-container">
                <h3><i class="fas fa-chart-line"></i> Monthly Attendance Trend</h3>
                <canvas id="attendanceChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        @endif

        <!-- Attendance Details Table -->
        <h3 style="color: white; margin-bottom: 20px;">Attendance Details</h3>

        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Course</th>
                    <th>Trainer</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendanceData as $record)
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
                        }
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->start_date)->format('M d, Y') }}</td>
                        <td>{{ $record->course_name }}</td>
                        <td>{{ $record->trainer_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->start_time)->format('g:i A') }}</td>
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
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--gray-light);">
                            <i class="fas fa-calendar-times"></i>
                            No attendance records found for this period.
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
    @if ($monthlyTrend->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            const months = @json($monthlyTrend->pluck('month'));
            const totals = @json($monthlyTrend->pluck('total'));
            const presents = @json($monthlyTrend->pluck('present'));

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months.map(m => {
                        const [year, month] = m.split('-');
                        return new Date(year, month - 1).toLocaleString('default', {
                            month: 'short',
                            year: 'numeric'
                        });
                    }),
                    datasets: [{
                            label: 'Present',
                            data: presents,
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Total Classes',
                            data: totals,
                            borderColor: '#ff5500',
                            backgroundColor: 'rgba(255, 85, 0, 0.1)',
                            tension: 0.4,
                            fill: true
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
                                color: 'rgba(255, 255, 255, 0.1)'
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
                // Gather data for export
                const data = {
                    member: {
                        id: '{{ $member->id }}',
                        name: '{{ $member->name }}',
                        code: '{{ $member->code }}',
                        email: '{{ $member->email }}',
                        phone: '{{ $member->phone }}'
                    },
                    date_range: {
                        start: '{{ $startDate->format('Y-m-d') }}',
                        end: '{{ $endDate->format('Y-m-d') }}'
                    },
                    stats: @json($stats),
                    attendance: @json($attendanceData)
                };

                // Create a form and submit to export endpoint
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('reports.export') }}';

                form.innerHTML = `
            @csrf
            <input type="hidden" name="type" value="member">
            <input type="hidden" name="format" value="${format}">
            <input type="hidden" name="data" value='${JSON.stringify(data)}'>
        `;

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    @endif
@endsection
