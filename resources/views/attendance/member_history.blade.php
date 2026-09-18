{{-- resources/views/attendance/member_history.blade.php --}}
@extends('layouts.home')

@section('title', 'Attendance History - ' . $member->name)

@section('css')
    <style>
        /* History Container - Light Theme */
        .history-container {
            padding: 30px;
        }

        /* Member Header - Light Theme */
        .member-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .member-avatar-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .member-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar-large i {
            font-size: 3rem;
            color: white;
        }

        .member-info h2 {
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 10px;
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

        /* ADDED: Payment Information Section - Light Theme */
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
            font-size: 1.2rem;
            font-weight: 600;
        }

        .payment-detail .value.text-danger {
            color: var(--danger);
        }

        .btn-payment-history {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(255, 85, 0, 0.2);
        }

        .btn-payment-history:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
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
            margin: 15px 0;
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

        /* Attendance Table - Light Theme */
        .attendance-table {
            width: 100%;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
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

        /* Pagination - Light Theme */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* ADDED: Monthly Trend Chart Styles */
        .monthly-trend {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
        }

        .monthly-trend h3 {
            color: var(--dark);
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .history-container {
                padding: 20px;
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
        }

        @media (max-width: 576px) {
            .history-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
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

        /* Animation for cards */
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

        .stat-card,
        .chart-container,
        .attendance-table {
            animation: fadeIn 0.3s ease forwards;
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

        /* Empty state for table */
        .attendance-table td[colspan] {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }

        /* Loading state */
        .loading-spinner {
            text-align: center;
            padding: 40px;
        }

        .loading-spinner i {
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
    <div class="history-container">
        <div class="member-header">
            <div class="member-avatar-large">
                @if (!empty($member->photo))
                    <img src="{{ asset('admin/uploads/' . $member->photo) }}" alt="{{ $member->name }}">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
            </div>
            <div class="member-info">
                <h2>{{ $member->name }}</h2>
                <p><i class="fas fa-id-card"></i> Code: {{ $member->code ?? 'N/A' }}</p>
                <p><i class="fas fa-envelope"></i> Email: {{ $member->email ?? 'N/A' }}</p>
                <p><i class="fas fa-phone"></i> Phone: {{ $member->phone ?? 'N/A' }}</p>
            </div>
        </div>

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
                <div class="stat-value" style="color: var(--warning);">{{ $stats['late'] }}</div>
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
        </div>

        @if ($monthlyData->count() > 0)
            <div class="chart-container">
                <h3 style="color: white; margin-bottom: 20px;">Monthly Attendance Trend</h3>
                <canvas id="attendanceChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        @endif

        <h3 style="color: white; margin-bottom: 20px;">Attendance History</h3>

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
                @forelse($attendances as $attendance)
                    @php
                        $statusClass = '';
                        if ($attendance->attendance_status == 'present') {
                            $statusClass = 'status-present';
                        } elseif ($attendance->attendance_status == 'late') {
                            $statusClass = 'status-late';
                        } elseif ($attendance->attendance_status == 'absent') {
                            $statusClass = 'status-absent';
                        } else {
                            $statusClass = '';
                        }
                    @endphp
                    <tr>
                        <td>{{ Carbon\Carbon::parse($attendance->start_date)->format('M d, Y') }}</td>
                        <td>{{ $attendance->course_name }}</td>
                        <td>{{ $attendance->trainer_name }}</td>
                        <td>{{ Carbon\Carbon::parse($attendance->start_time)->format('g:i A') }}</td>
                        <td>
                            @if ($attendance->attendance_status)
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucfirst($attendance->attendance_status) }}
                                </span>
                            @else
                                <span class="status-badge">Not Marked</span>
                            @endif
                        </td>
                        <td>{{ $attendance->check_in_time ?? '--:--' }}</td>
                        <td>{{ $attendance->check_out_time ?? '--:--' }}</td>
                        <td>
                            @if ($attendance->duration_minutes)
                                {{ floor($attendance->duration_minutes / 60) }}h {{ $attendance->duration_minutes % 60 }}m
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--gray-light);">
                            <i class="fas fa-info-circle"></i> No attendance records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $attendances->links() }}
        </div>
    </div>
@endsection

@section('script')
    @if ($monthlyData->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            const months = @json($monthlyData->pluck('month'));
            const totals = @json($monthlyData->pluck('total'));
            const presents = @json($monthlyData->pluck('present'));

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
                        tension: 0.4
                    }, {
                        label: 'Total Classes',
                        data: totals,
                        borderColor: '#ff5500',
                        backgroundColor: 'rgba(255, 85, 0, 0.1)',
                        tension: 0.4
                    }]
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
                                color: '#aaa'
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
        </script>
    @endif
@endsection
