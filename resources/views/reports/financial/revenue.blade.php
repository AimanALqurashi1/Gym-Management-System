{{-- resources/views/reports/financial/revenue.blade.php --}}
@extends('layouts.home')

@section('title', 'Revenue Analysis Report')

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
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            color: var(--gray);
            margin-bottom: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .filter-select {
            width: 100%;
            padding: 10px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            transition: var(--transition);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .btn-filter {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            height: 42px;
            transition: var(--transition);
        }

        .btn-filter:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Summary Cards - Light Theme */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255, 85, 0, 0.08);
            border-radius: 50%;
        }

        .summary-label {
            color: var(--gray);
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .summary-value {
            color: var(--dark);
            font-size: 2.5rem;
            font-weight: 700;
        }

        .summary-trend {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--danger);
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

        /* Payment Stats Grid - Light Theme */
        .payment-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .payment-stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .payment-stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .payment-stat-value {
            color: var(--dark);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .payment-stat-label {
            color: var(--gray);
            margin-top: 5px;
            font-size: 0.85rem;
        }

        .badge-overdue {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            display: inline-block;
            margin-top: 8px;
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

        /* Category List - Light Theme */
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .category-item:hover {
            background: var(--primary-light);
            padding-left: 8px;
            border-radius: 8px;
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .category-name {
            color: var(--dark);
        }

        .category-amount {
            color: var(--dark);
            font-weight: 600;
        }

        .category-percent {
            color: var(--gray);
            margin-left: 10px;
        }

        /* Trainer Table - Light Theme */
        .trainer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .trainer-table th {
            text-align: left;
            padding: 10px;
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .trainer-table td {
            padding: 10px;
            color: var(--dark);
            border-top: 1px solid var(--border-color);
        }

        .trainer-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* ADDED: Export Options */
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

            .payment-stats-grid {
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

            .filter-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filter {
                width: 100%;
            }

            .summary-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .summary-value {
                font-size: 1.8rem;
            }

            .payment-stats-grid {
                grid-template-columns: 1fr;
            }

            .category-item {
                flex-direction: column;
                align-items: flex-start;
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

            .summary-card {
                padding: 15px;
            }

            .summary-value {
                font-size: 1.5rem;
            }

            .data-card {
                padding: 15px;
            }

            .trainer-table th,
            .trainer-table td {
                padding: 8px;
                font-size: 0.8rem;
            }

            .export-options {
                flex-direction: column;
            }

            .btn-export {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animation for cards */
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

        .summary-card,
        .data-card,
        .chart-container {
            animation: fadeInUp 0.3s ease forwards;
        }

        .summary-card:nth-child(1) {
            animation-delay: 0s;
        }

        .summary-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .summary-card:nth-child(3) {
            animation-delay: 0.1s;
        }
    </style>
@endsection

@section('content')
    <div class="report-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-chart-pie"></i>
                Revenue Analysis Report
            </h1>
            <div class="header-actions">
                <a href="{{ route('reports.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Reports
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form action="{{ route('reports.financial.revenue') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <label>Period</label>
                    <select name="period" class="filter-select">
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ $period == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Year</label>
                    <select name="year" class="filter-select">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Apply
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-label">Total Revenue</div>
                <div class="summary-value">${{ number_format($summary['total_revenue'], 2) }}</div>
                <div class="summary-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ $summary['growth_rate'] }}% vs last period
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Average Monthly</div>
                <div class="summary-value">${{ number_format($summary['average_monthly'], 2) }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Top Category</div>
                <div class="summary-value">{{ $summary['top_category'] }}</div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="chart-container">
            <h3><i class="fas fa-chart-line"></i> Revenue Trend</h3>
            <canvas id="revenueChart" style="width: 100%; height: 350px;"></canvas>
        </div>

        <!-- Data Grid -->
        <div class="data-grid">
            <!-- Revenue by Category -->
            <div class="data-card">
                <h3><i class="fas fa-chart-pie"></i> Revenue by Category</h3>
                <ul class="category-list">
                    @php
                        $colors = ['#ff5500', '#28a745', '#17a2b8', '#ffc107', '#6f42c1'];
                    @endphp
                    @foreach ($categoryRevenue as $index => $category)
                        <li class="category-item">
                            <div class="category-info">
                                <div class="category-color" style="background: {{ $colors[$index % count($colors)] }};">
                                </div>
                                <span class="category-name">{{ $category['category'] }}</span>
                            </div>
                            <div>
                                <span class="category-amount">${{ number_format($category['revenue'], 2) }}</span>
                                <span class="category-percent">({{ $category['percentage'] }}%)</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Revenue by Trainer -->
            <div class="data-card">
                <h3><i class="fas fa-chalkboard-teacher"></i> Revenue by Trainer</h3>
                <table class="trainer-table">
                    <thead>
                        <tr>
                            <th>Trainer</th>
                            <th>Classes</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainerRevenue as $trainer)
                            <tr>
                                <td>{{ $trainer['name'] }}</td>
                                <td>{{ $trainer['classes'] }}</td>
                                <td>${{ number_format($trainer['revenue'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');

        const revenueData = @json($revenueData);

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueData.map(d => d.label),
                datasets: [{
                        label: 'Revenue',
                        data: revenueData.map(d => d.revenue),
                        borderColor: '#ff5500',
                        backgroundColor: 'rgba(255, 85, 0, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Memberships',
                        data: revenueData.map(d => d.memberships || 0),
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#aaa',
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: '#aaa'
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
                period: '{{ $period }}',
                year: '{{ $year }}',
                summary: @json($summary),
                revenueData: @json($revenueData),
                categoryRevenue: @json($categoryRevenue),
                trainerRevenue: @json($trainerRevenue)
            };

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('reports.export') }}';

            form.innerHTML = `
            @csrf
            <input type="hidden" name="type" value="financial">
            <input type="hidden" name="format" value="${format}">
            <input type="hidden" name="data" value='${JSON.stringify(data)}'>
        `;

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
