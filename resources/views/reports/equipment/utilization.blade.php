{{-- resources/views/reports/equipment/utilization.blade.php --}}
@extends('layouts.home')

@section('title', 'Equipment Utilization Report')

@section('css')
    <style>
        /* Preview Container - Light Theme */
        .preview-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Preview Card - Light Theme */
        .preview-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Card Header - Light Theme */
        .card-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            padding: 25px;
            border-bottom: 2px solid var(--primary);
        }

        .card-header h2 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h2 i {
            color: var(--primary);
        }

        /* Info Section - Light Theme */
        .info-section {
            padding: 20px;
        }

        /* Info Row - Light Theme */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--gray);
            font-weight: 500;
        }

        .info-value {
            color: var(--dark);
            font-weight: 600;
        }

        .info-value i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Refund Calculator - Light Theme */
        .refund-calculator {
            background: #fafafa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            border: 1px solid var(--border-color);
        }

        .refund-calculator h4 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .refund-calculator h4 i {
            color: var(--primary);
        }

        /* Refund Amount - Light Theme */
        .refund-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin: 15px 0;
        }

        .refund-percentage {
            text-align: center;
            margin-bottom: 10px;
        }

        .refund-percentage span {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
        }

        /* Rule Box - Light Theme */
        .rule-box {
            background: rgba(255, 193, 7, 0.05);
            border-left: 4px solid var(--warning);
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
        }

        .rule-box i {
            color: var(--warning);
            margin-right: 10px;
        }

        .rule-box strong {
            color: var(--warning);
        }

        .rule-box p {
            color: var(--dark);
            margin: 0;
        }

        .rule-box ul {
            margin-top: 10px;
            padding-left: 25px;
        }

        .rule-box li {
            color: var(--gray);
            margin: 5px 0;
        }

        /* Refund Summary - Light Theme */
        .refund-summary {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            margin: 20px;
            border: 1px solid var(--border-color);
        }

        .refund-summary .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .refund-summary .summary-label {
            color: var(--gray);
        }

        .refund-summary .summary-value {
            color: var(--dark);
            font-weight: 600;
        }

        .refund-summary .summary-value.highlight {
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Buttons - Light Theme */
        .btn-cancel-action {
            background: var(--danger);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.2);
        }

        .btn-cancel-action:hover {
            background: #bd2130;
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray);
            border: 2px solid var(--border-color);
            padding: 10px 22px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            font-weight: 600;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin: 20px;
            justify-content: flex-end;
        }

        /* ADDED: Eligibility Status */
        .eligibility-status {
            text-align: center;
            padding: 10px;
            margin: 20px;
            border-radius: 8px;
        }

        .eligibility-status.eligible {
            background: rgba(40, 167, 69, 0.08);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .eligibility-status.not-eligible {
            background: rgba(220, 53, 69, 0.05);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .eligibility-status i {
            margin-right: 8px;
        }

        /* ADDED: Days Counter */
        .days-counter {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background: #fafafa;
            border-radius: 8px;
        }

        .days-counter .days-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .days-counter .days-label {
            color: var(--gray);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .preview-container {
                padding: 20px;
            }

            .card-header {
                padding: 20px;
            }

            .card-header h2 {
                font-size: 1.3rem;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .refund-amount {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn-secondary,
            .action-buttons .btn-cancel-action {
                width: 100%;
                justify-content: center;
            }

            .refund-calculator,
            .rule-box,
            .refund-summary {
                margin: 15px;
            }

            .info-section {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .preview-container {
                padding: 15px;
            }

            .card-header {
                padding: 15px;
            }

            .card-header h2 {
                font-size: 1.1rem;
            }

            .refund-amount {
                font-size: 1.3rem;
            }

            .refund-calculator,
            .rule-box,
            .refund-summary {
                margin: 10px;
                padding: 12px;
            }

            .btn-cancel-action,
            .btn-secondary {
                padding: 10px 16px;
                font-size: 0.9rem;
            }

            .days-counter .days-number {
                font-size: 1.2rem;
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

        .preview-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Warning highlight for important numbers */
        .highlight-warning {
            color: var(--warning);
            font-weight: 700;
        }

        .highlight-danger {
            color: var(--danger);
            font-weight: 700;
        }

        .highlight-success {
            color: var(--success);
            font-weight: 700;
        }

        /* Refund rule icons */
        .rule-icon {
            display: inline-block;
            width: 24px;
            text-align: center;
            margin-right: 8px;
        }

        .rule-icon i {
            font-size: 0.9rem;
        }

        .rule-icon .fa-check-circle {
            color: var(--success);
        }

        .rule-icon .fa-times-circle {
            color: var(--danger);
        }

        .rule-icon .fa-clock {
            color: var(--warning);
        }
    </style>
@endsection

@section('content')
    <div class="report-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-tools"></i>
                Equipment Utilization Report
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
            <form action="{{ route('reports.equipment.utilization') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <label>Category</label>
                    <select name="category_id" class="filter-select">
                        <option value="all">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-select">
                        <option value="all">All Status</option>
                        <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="in_use" {{ $status == 'in_use' ? 'selected' : '' }}>In Use</option>
                        <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Date Range</label>
                    <select name="date_range" class="filter-select">
                        <option value="month" {{ $dateRange == 'month' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="quarter" {{ $dateRange == 'quarter' ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="year" {{ $dateRange == 'year' ? 'selected' : '' }}>Last 12 Months</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Apply
                </button>
            </form>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $equipmentStats['total'] }}</div>
                <div class="stat-label">Total Equipment</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $equipmentStats['available'] }}</div>
                <div class="stat-label">Available</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $equipmentStats['in_use'] }}</div>
                <div class="stat-label">In Use</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $equipmentStats['maintenance'] }}</div>
                <div class="stat-label">In Maintenance</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">${{ number_format($equipmentStats['total_value'], 2) }}</div>
                <div class="stat-label">Total Value</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $utilizationRate }}%</div>
                <div class="stat-label">Utilization Rate</div>
                <div class="utilization-meter">
                    <div class="utilization-fill" style="width: {{ $utilizationRate }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Maintenance Cost Chart -->
        @if ($maintenanceCosts->count() > 0)
            <div class="chart-container">
                <h3><i class="fas fa-chart-line"></i> Maintenance Costs Trend</h3>
                <canvas id="maintenanceChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        @endif

        <!-- Data Grid -->
        <div class="data-grid">
            <!-- Category Breakdown -->
            <div class="data-card">
                <h3><i class="fas fa-folder"></i> Equipment by Category</h3>
                <table class="category-stats">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total</th>
                            <th>Available</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryStats as $category)
                            <tr>
                                <td>{{ $category->category }}</td>
                                <td>{{ $category->total }}</td>
                                <td>{{ $category->available }}</td>
                                <td>${{ number_format($category->total_value, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Most Used Equipment -->
            <div class="data-card">
                <h3><i class="fas fa-star"></i> Most Used Equipment</h3>
                <ul class="top-equipment">
                    @foreach ($mostUsed as $item)
                        <li class="equipment-item">
                            <div class="equipment-info">
                                <div class="equipment-name">{{ $item['name'] }}</div>
                                <div class="equipment-category">{{ $item['category'] }} • {{ $item['code'] }}</div>
                            </div>
                            <div class="equipment-usage">{{ $item['usage_count'] }} uses</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Maintenance History -->
        @if ($maintenanceCosts->count() > 0)
            <div class="data-card">
                <h3><i class="fas fa-history"></i> Maintenance Summary</h3>
                <ul class="maintenance-trend">
                    @foreach ($maintenanceCosts as $item)
                        <li class="trend-item">
                            <span
                                class="trend-month">{{ \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('M Y') }}</span>
                            <div>
                                <span class="trend-cost">${{ number_format($item->total_cost, 2) }}</span>
                                <span class="trend-count">({{ $item->maintenance_count }} records)</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

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
    @if ($maintenanceCosts->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('maintenanceChart').getContext('2d');

            const maintenanceData = @json($maintenanceCosts);

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: maintenanceData.map(d => {
                        const [year, month] = d.month.split('-');
                        return new Date(year, month - 1).toLocaleString('default', {
                            month: 'short',
                            year: 'numeric'
                        });
                    }),
                    datasets: [{
                            label: 'Maintenance Cost',
                            data: maintenanceData.map(d => d.total_cost),
                            backgroundColor: 'rgba(255, 85, 0, 0.7)',
                            borderColor: '#ff5500',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Number of Maintenance',
                            data: maintenanceData.map(d => d.maintenance_count),
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: '#28a745',
                            borderWidth: 1,
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
                    date_range: '{{ $dateRange }}',
                    stats: @json($equipmentStats),
                    categoryStats: @json($categoryStats),
                    mostUsed: @json($mostUsed),
                    maintenanceCosts: @json($maintenanceCosts)
                };

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('reports.export') }}';

                form.innerHTML = `
            @csrf
            <input type="hidden" name="type" value="equipment">
            <input type="hidden" name="format" value="${format}">
            <input type="hidden" name="data" value='${JSON.stringify(data)}'>
        `;

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    @endif
@endsection
