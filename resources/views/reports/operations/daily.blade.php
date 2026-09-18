{{-- resources/views/reports/operations/daily.blade.php --}}
@extends('layouts.home')

@section('title', 'Daily Operations Report - ' . $date->format('F j, Y'))

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

        /* Date Selector - Light Theme */
        .date-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .date-nav {
            color: var(--dark);
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 50%;
            transition: var(--transition);
        }

        .date-nav:hover {
            background: var(--primary);
            color: white;
        }

        .current-date {
            color: var(--dark);
            font-weight: 600;
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

        /* Summary Card - Light Theme */
        .summary-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .summary-title {
            color: var(--dark);
            font-size: 1.2rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-title i {
            color: var(--primary);
        }

        /* Attendance Rate - Light Theme */
        .attendance-rate {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .rate-circle {
            width: 120px;
            height: 120px;
            position: relative;
        }

        .rate-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--dark);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .rate-details {
            flex: 1;
        }

        .rate-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .rate-item:last-child {
            border-bottom: none;
        }

        .rate-label {
            color: var(--gray);
        }

        .rate-number {
            color: var(--dark);
            font-weight: 600;
        }

        /* Occupancy Table - Light Theme */
        .occupancy-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .occupancy-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .occupancy-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
        }

        .occupancy-table tbody tr:hover {
            background: var(--primary-light);
        }

        .occupancy-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Progress Bar - Light Theme */
        .progress-bar {
            width: 100px;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--success);
            border-radius: 4px;
            transition: width 0.3s ease;
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

        .badge-warning {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .badge-info {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        .badge-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Equipment Section - Light Theme */
        .equipment-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .equipment-section h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .equipment-section h3 i {
            color: var(--primary);
        }

        /* Equipment List - Light Theme */
        .equipment-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .equipment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .equipment-item:hover {
            background: var(--primary-light);
            padding-left: 8px;
            border-radius: 8px;
        }

        .equipment-item:last-child {
            border-bottom: none;
        }

        .equipment-name {
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .equipment-name i {
            color: var(--primary);
        }

        .equipment-assignee {
            color: var(--gray);
            font-size: 0.85rem;
        }

        /* ADDED: Payment Status Card */
        .payment-status-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .payment-status-card h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-status-card h3 i {
            color: var(--primary);
        }

        .payment-status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
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

        /* Responsive */
        @media (max-width: 768px) {
            .report-container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .date-selector {
                width: 100%;
                justify-content: space-between;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-value {
                font-size: 1.8rem;
            }

            .attendance-rate {
                flex-direction: column;
                text-align: center;
            }

            .rate-details {
                width: 100%;
            }

            .occupancy-table {
                display: block;
                overflow-x: auto;
            }

            .equipment-item {
                flex-direction: column;
                text-align: center;
                gap: 8px;
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

            .summary-card {
                padding: 15px;
            }

            .rate-circle {
                width: 100px;
                height: 100px;
            }

            .rate-text {
                font-size: 1.4rem;
            }

            .occupancy-table th,
            .occupancy-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .progress-bar {
                width: 80px;
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
        .summary-card,
        .occupancy-table,
        .equipment-section {
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
                <i class="fas fa-calendar-day"></i>
                Daily Operations Report
            </h1>
            <div class="date-selector">
                <a href="{{ route('reports.operations.daily', ['date' => $date->copy()->subDay()->format('Y-m-d')]) }}"
                    class="date-nav">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <span class="current-date">{{ $date->format('l, F j, Y') }}</span>
                <a href="{{ route('reports.operations.daily', ['date' => $date->copy()->addDay()->format('Y-m-d')]) }}"
                    class="date-nav">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_classes'] }}</div>
                <div class="stat-label">Total Classes</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_trainers'] }}</div>
                <div class="stat-label">Active Trainers</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_expected'] }}</div>
                <div class="stat-label">Expected Members</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_present'] }}</div>
                <div class="stat-label">Present Today</div>
            </div>
        </div>

        <!-- Attendance Summary -->
        <div class="summary-card">
            <div class="summary-title">
                <i class="fas fa-chart-pie"></i>
                Attendance Summary
            </div>
            <div class="attendance-rate">
                <div class="rate-circle">
                    <canvas id="attendanceDonut" width="120" height="120"></canvas>
                    <div class="rate-text">{{ $stats['attendance_rate'] }}%</div>
                </div>
                <div class="rate-details">
                    <div class="rate-item">
                        <span class="rate-label"><i class="fas fa-check-circle" style="color: var(--success);"></i>
                            Present</span>
                        <span class="rate-number">{{ $stats['total_present'] }}</span>
                    </div>
                    <div class="rate-item">
                        <span class="rate-label"><i class="fas fa-times-circle" style="color: var(--danger);"></i>
                            Absent</span>
                        <span class="rate-number">{{ $stats['total_absent'] }}</span>
                    </div>
                    <div class="rate-item">
                        <span class="rate-label"><i class="fas fa-clock" style="color: var(--warning);"></i> Not
                            Marked</span>
                        <span
                            class="rate-number">{{ $stats['total_expected'] - $stats['total_present'] - $stats['total_absent'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Occupancy -->
        <h3 style="color: white; margin-bottom: 20px;">Class Occupancy</h3>

        <table class="occupancy-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Course</th>
                    <th>Trainer</th>
                    <th>Capacity</th>
                    <th>Enrolled</th>
                    <th>Present</th>
                    <th>Occupancy</th>
                </tr>
            </thead>
            <tbody>
                @forelse($occupancyData as $class)
                    <tr>
                        <td>{{ $class['time'] }}</td>
                        <td>{{ $class['course'] }}</td>
                        <td>{{ $class['trainer'] }}</td>
                        <td>{{ $class['capacity'] }}</td>
                        <td>{{ $class['enrolled'] }}</td>
                        <td>{{ $class['present'] }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span>{{ $class['occupancy_rate'] }}%</span>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $class['occupancy_rate'] }}%;"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--gray-light);">
                            <i class="fas fa-calendar-times"></i>
                            No classes scheduled for this day.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Equipment in Use -->
        @if ($equipmentInUse->count() > 0)
            <div class="equipment-section">
                <h3 style="color: white; margin-bottom: 20px;">
                    <i class="fas fa-tools"></i>
                    Equipment Currently in Use
                </h3>

                <ul class="equipment-list">
                    @foreach ($equipmentInUse as $assignment)
                        <li class="equipment-item">
                            <div class="equipment-name">
                                <i class="fas fa-toolbox" style="color: var(--primary);"></i>
                                {{ $assignment->equipment->name }}
                                <span class="equipment-assignee">
                                    ({{ $assignment->quantity }}x -
                                    @if ($assignment->assignable_type == 'App\\Models\\Member')
                                        Member: {{ $assignment->assignable->name ?? 'Unknown' }}
                                    @else
                                        Trainer: {{ $assignment->assignable->name ?? 'Unknown' }}
                                    @endif)
                                </span>
                            </div>
                            <span class="badge badge-success">In Use</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Export Options -->
        <div class="export-options" style="margin-top: 30px;">
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
        // Attendance Donut Chart
        const ctx = document.getElementById('attendanceDonut').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Not Marked'],
                datasets: [{
                    data: [
                        {{ $stats['total_present'] }},
                        {{ $stats['total_absent'] }},
                        {{ $stats['total_expected'] - $stats['total_present'] - $stats['total_absent'] }}
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });

        function exportReport(format) {
            const data = {
                date: '{{ $date->format('Y-m-d') }}',
                stats: @json($stats),
                occupancyData: @json($occupancyData),
                equipmentInUse: @json($equipmentInUse)
            };

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('reports.export') }}';

            form.innerHTML = `
            @csrf
            <input type="hidden" name="type" value="operations">
            <input type="hidden" name="format" value="${format}">
            <input type="hidden" name="data" value='${JSON.stringify(data)}'>
        `;

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
