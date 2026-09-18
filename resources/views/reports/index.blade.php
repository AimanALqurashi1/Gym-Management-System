{{-- resources/views/reports/index.blade.php --}}
@extends('layouts.home')

@section('title', 'Reports Dashboard')

@section('css')
    <style>
        /* Reports Container - Light Theme */
        .reports-container {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: var(--dark);
            font-size: 2.2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header h1 i {
            color: var(--primary);
        }

        /* Stats Grid - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.members {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.trainers {
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
        }

        .stat-icon.classes {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .stat-icon.equipment {
            background: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .stat-icon.revenue {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-icon.attendance {
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 2rem;
            margin: 0;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
            font-size: 0.9rem;
        }

        /* Reports Grid - Light Theme */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .report-category {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .report-category:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .category-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .category-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .category-header h3 {
            color: var(--dark);
            margin: 0;
            font-size: 1.3rem;
        }

        /* Report List - Light Theme */
        .report-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .report-item {
            margin-bottom: 10px;
        }

        .report-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--gray);
            text-decoration: none;
            transition: var(--transition);
        }

        .report-link:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--dark);
            transform: translateX(5px);
        }

        .report-link i {
            width: 20px;
            color: var(--primary);
        }

        .report-link span {
            flex: 1;
        }

        .report-link .badge {
            background: var(--primary);
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        /* Recent Reports - Light Theme */
        .recent-reports {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .recent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .recent-header h3 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recent-header h3 i {
            color: var(--primary);
        }

        .btn-view-all {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--gray);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view-all:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* Recent Table - Light Theme */
        .recent-table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-table th {
            text-align: left;
            padding: 12px;
            color: var(--gray);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
        }

        .recent-table td {
            padding: 12px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
        }

        .recent-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Report Type Badge - Light Theme */
        .report-type {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .type-attendance {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .type-trainer {
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
            border: 1px solid rgba(255, 85, 0, 0.2);
        }

        .type-equipment {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        .type-financial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .type-analytics {
            background: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
            border: 1px solid rgba(111, 66, 193, 0.2);
        }

        /* Button View - Light Theme */
        .btn-view {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--gray);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .reports-container {
                padding: 20px;
            }

            .reports-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .category-header h3 {
                font-size: 1.1rem;
            }

            .recent-table {
                display: block;
                overflow-x: auto;
            }

            .recent-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .reports-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.6rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }

            .stat-info h3 {
                font-size: 1.3rem;
            }

            .report-category {
                padding: 15px;
            }

            .report-link {
                padding: 8px 12px;
            }

            .recent-reports {
                padding: 15px;
            }

            .recent-table th,
            .recent-table td {
                padding: 8px;
                font-size: 0.8rem;
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
        .report-category,
        .recent-reports {
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

        .stat-card:nth-child(5) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(6) {
            animation-delay: 0.25s;
        }

        .report-category:nth-child(1) {
            animation-delay: 0s;
        }

        .report-category:nth-child(2) {
            animation-delay: 0.1s;
        }

        .report-category:nth-child(3) {
            animation-delay: 0.2s;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Loading State */
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
    <div class="reports-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-chart-pie"></i>
                Reports Dashboard
            </h1>
        </div>

        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon members">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_members'] }}</h3>
                    <p>Active Members</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon trainers">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['active_trainers'] }}</h3>
                    <p>Active Trainers</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon classes">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_classes_today'] }}</h3>
                    <p>Classes Today</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon equipment">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['equipment_count'] }}</h3>
                    <p>Equipment Items</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($stats['monthly_revenue']['total'] ?? 0, 2) }}</h3>
                    <p>Monthly Revenue</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon attendance">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['attendance_rate'] ?? 0 }}%</h3>
                    <p>Attendance Rate</p>
                </div>
            </div>
        </div>

        <!-- Reports Categories -->
        <div class="reports-grid">
            <!-- Member Reports -->
            <div class="report-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Member Reports</h3>
                </div>
                <ul class="report-list">
                    <li class="report-item">
                        <a href="{{ route('reports.member.attendance') }}" class="report-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Member Attendance History</span>
                            <span class="badge">Individual</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Member Progress Report</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-clock"></i>
                            <span>Check-in/out Times</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Trainer Reports -->
            <div class="report-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Trainer Reports</h3>
                </div>
                <ul class="report-list">
                    <li class="report-item">
                        <a href="{{ route('reports.trainer.performance') }}" class="report-link">
                            <i class="fas fa-trophy"></i>
                            <span>Trainer Performance</span>
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Trainer Schedule Overview</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-users"></i>
                            <span>Class Size by Trainer</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Financial Reports -->
            <div class="report-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Financial Reports</h3>
                </div>
                <ul class="report-list">
                    <li class="report-item">
                        <a href="{{ route('reports.financial.revenue') }}" class="report-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Revenue Analysis</span>
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Membership Revenue</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-tools"></i>
                            <span>Equipment Costs</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Equipment Reports -->
            <div class="report-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Equipment Reports</h3>
                </div>
                <ul class="report-list">
                    <li class="report-item">
                        <a href="{{ route('reports.equipment.utilization') }}" class="report-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Equipment Utilization</span>
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-wrench"></i>
                            <span>Maintenance History</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-clock"></i>
                            <span>Downtime Analysis</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Operations Reports -->
            <div class="report-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Operations Reports</h3>
                </div>
                <ul class="report-list">
                    <li class="report-item">
                        <a href="{{ route('reports.operations.daily') }}" class="report-link">
                            <i class="fas fa-calendar-day"></i>
                            <span>Daily Operations</span>
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-chair"></i>
                            <span>Class Occupancy</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-clock"></i>
                            <span>Peak Hours</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Analytics Reports -->
            <div class="report-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Analytics</h3>
                </div>
                <ul class="report-list">
                    <li class="report-item">
                        <a href="{{ route('reports.analytics.retention') }}" class="report-link">
                            <i class="fas fa-user-graduate"></i>
                            <span>Member Retention</span>
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="{{ route('reports.analytics.popularity') }}" class="report-link">
                            <i class="fas fa-fire"></i>
                            <span>Class Popularity</span>
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li class="report-item">
                        <a href="#" class="report-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Growth Trends</span>
                            <span class="badge">Coming Soon</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="recent-reports">
            <div class="recent-header">
                <h3><i class="fas fa-history"></i> Recently Generated Reports</h3>
                <a href="#" class="btn-view">
                    <i class="fas fa-eye"></i> View All
                </a>
            </div>

            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Type</th>
                        <th>Generated Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReports as $report)
                        <tr>
                            <td>{{ $report['name'] }}</td>
                            <td>
                                <span class="report-type type-{{ $report['type'] }}">
                                    {{ ucfirst($report['type']) }}
                                </span>
                            </td>
                            <td>{{ $report['date']->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="#" class="btn-view">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--gray-light); padding: 20px;">
                                <i class="fas fa-info-circle"></i> No recent reports found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
