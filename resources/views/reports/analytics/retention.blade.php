{{-- resources/views/reports/analytics/retention.blade.php --}}
@extends('layouts.home')

@section('title', 'Member Retention Analysis')

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
            cursor: pointer;
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

        /* Retention Table - Light Theme */
        .retention-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .retention-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            font-weight: 600;
            padding: 15px;
            text-align: center;
            border-bottom: 2px solid var(--border-color);
        }

        .retention-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            text-align: center;
        }

        .retention-table tbody tr:hover {
            background: var(--primary-light);
        }

        .retention-table tr:last-child td {
            border-bottom: none;
        }

        .cohort-header {
            background: var(--primary-light);
            color: var(--dark) !important;
            font-weight: 700;
        }

        .rate-cell {
            font-weight: 600;
        }

        .rate-high {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border-radius: 20px;
            display: inline-block;
            padding: 4px 12px;
        }

        .rate-medium {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border-radius: 20px;
            display: inline-block;
            padding: 4px 12px;
        }

        .rate-low {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border-radius: 20px;
            display: inline-block;
            padding: 4px 12px;
        }

        /* Insights Card - Light Theme */
        .insights-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .insights-title {
            color: var(--dark);
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .insights-title i {
            color: var(--primary);
        }

        /* Insights Grid - Light Theme */
        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .insight-item {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .insight-item:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .insight-label {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .insight-value {
            color: var(--dark);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .insight-trend {
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--danger);
        }

        /* ADDED: Popularity Report Styles */
        .popularity-container {
            padding: 30px;
        }

        .popularity-chart {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
        }

        .popularity-chart h3 {
            color: var(--dark);
            margin-bottom: 20px;
        }

        .popularity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .popularity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .popularity-item:last-child {
            border-bottom: none;
        }

        .popularity-name {
            color: var(--dark);
            font-weight: 500;
        }

        .popularity-value {
            color: var(--primary);
            font-weight: 600;
        }

        .popularity-bar {
            flex: 1;
            margin: 0 15px;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .popularity-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 4px;
            transition: width 0.3s ease;
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

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filter {
                width: 100%;
            }

            .retention-table {
                display: block;
                overflow-x: auto;
            }

            .insights-grid {
                grid-template-columns: 1fr;
            }

            .cohort-header {
                font-size: 0.85rem;
            }

            .rate-cell {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .report-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .chart-container {
                padding: 15px;
            }

            .chart-container h3 {
                font-size: 1.1rem;
            }

            .insight-value {
                font-size: 1.3rem;
            }

            .insight-item {
                padding: 12px;
            }

            .retention-table th,
            .retention-table td {
                padding: 8px;
                font-size: 0.75rem;
            }
        }

        /* Animation */
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

        .insight-item {
            animation: fadeIn 0.3s ease forwards;
        }

        .insight-item:nth-child(1) {
            animation-delay: 0s;
        }

        .insight-item:nth-child(2) {
            animation-delay: 0.05s;
        }

        .insight-item:nth-child(3) {
            animation-delay: 0.1s;
        }

        .insight-item:nth-child(4) {
            animation-delay: 0.15s;
        }

        /* Tooltip styles */
        .tooltip-icon {
            color: var(--gray);
            cursor: help;
            margin-left: 5px;
            font-size: 0.8rem;
        }

        .tooltip-icon:hover {
            color: var(--primary);
        }

        /* Loading state */
        .loading {
            text-align: center;
            padding: 60px;
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
                <i class="fas fa-user-graduate"></i>
                Member Retention Analysis
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
            <form action="{{ route('reports.analytics.retention') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <label>Period</label>
                    <select name="period" class="filter-select">
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ $period == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Apply
                </button>
            </form>
        </div>

        <!-- Retention Chart -->
        <div class="chart-container">
            <h3><i class="fas fa-chart-line"></i> Retention Curve</h3>
            <canvas id="retentionChart" style="width: 100%; height: 350px;"></canvas>
        </div>

        <!-- Cohort Analysis Table -->
        <h3 style="color: white; margin-bottom: 20px;">Cohort Analysis</h3>

        <table class="retention-table">
            <thead>
                <tr>
                    <th>Cohort</th>
                    <th>Month 1</th>
                    <th>Month 2</th>
                    <th>Month 3</th>
                    <th>Month 4</th>
                    <th>Month 5</th>
                    <th>Month 6</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($retentionData as $cohort)
                    <tr>
                        <td class="cohort-header">{{ $cohort['cohort'] }}</td>
                        @for ($i = 1; $i <= 6; $i++)
                            @php
                                $rate = $cohort["month{$i}"] ?? 0;
                                $rateClass = '';
                                if ($rate >= 80) {
                                    $rateClass = 'rate-high';
                                } elseif ($rate >= 60) {
                                    $rateClass = 'rate-medium';
                                } elseif ($rate > 0) {
                                    $rateClass = 'rate-low';
                                }
                            @endphp
                            <td class="rate-cell {{ $rateClass }}">{{ $rate }}%</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Key Insights -->
        <div class="insights-card">
            <div class="insights-title">
                <i class="fas fa-lightbulb"></i>
                Key Insights
            </div>
            <div class="insights-grid">
                <div class="insight-item">
                    <div class="insight-label">Average 1-Month Retention</div>
                    <div class="insight-value">87%</div>
                    <div class="insight-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +5% vs last period
                    </div>
                </div>
                <div class="insight-item">
                    <div class="insight-label">Average 3-Month Retention</div>
                    <div class="insight-value">72%</div>
                    <div class="insight-trend trend-up">
                        <i class="fas fa-arrow-up"></i> +3% vs last period
                    </div>
                </div>
                <div class="insight-item">
                    <div class="insight-label">Average 6-Month Retention</div>
                    <div class="insight-value">58%</div>
                    <div class="insight-trend trend-down">
                        <i class="fas fa-arrow-down"></i> -2% vs last period
                    </div>
                </div>
                <div class="insight-item">
                    <div class="insight-label">Best Cohort</div>
                    <div class="insight-value">Jan 2026</div>
                    <div class="insight-trend">92% retention</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('retentionChart').getContext('2d');

        const retentionData = @json($retentionData);

        // Prepare data for chart
        const months = ['Month 1', 'Month 2', 'Month 3', 'Month 4', 'Month 5', 'Month 6'];
        const datasets = retentionData.slice(0, 5).map((cohort, index) => ({
            label: cohort.cohort,
            data: [cohort.month1, cohort.month2, cohort.month3, cohort.month4, cohort.month5, cohort.month6],
            borderColor: `hsl(${index * 50}, 70%, 50%)`,
            backgroundColor: 'transparent',
            tension: 0.4
        }));

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#aaa',
                            callback: function(value) {
                                return value + '%';
                            }
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
    </script>
@endsection
