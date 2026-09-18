@extends('layouts.home')

@section('title', 'My Statistics')

@section('css')
    <style>
        /* Statistics Container - Light Theme */
        .statistics-container {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
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

        /* Date Range Picker - Light Theme */
        .date-range-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .date-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .date-group {
            flex: 1;
            min-width: 180px;
        }

        .date-group label {
            display: block;
            color: var(--gray);
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        .date-group input {
            width: 100%;
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            color: var(--dark);
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition);
        }

        .date-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .btn-apply {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-apply:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-export {
            background: var(--info);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-export:hover {
            background: #138496;
            transform: translateY(-2px);
        }

        /* Stats Grid - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-header i {
            font-size: 2rem;
            color: var(--primary);
            opacity: 0.5;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-trend {
            margin-top: 10px;
            font-size: 0.8rem;
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

        .trend-neutral {
            color: var(--warning);
        }

        /* Charts Container - Light Theme */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .chart-card:hover {
            border-color: var(--border-primary);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .chart-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, white, #fafafa);
        }

        .chart-header h3 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .chart-header h3 i {
            color: var(--primary);
        }

        .chart-body {
            padding: 20px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Course Breakdown - Light Theme */
        .course-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .course-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--secondary-light);
            border-radius: 12px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .course-item:hover {
            transform: translateX(5px);
            background: var(--primary-light);
            border-color: var(--border-primary);
        }

        .course-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .course-icon i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .course-info {
            flex: 1;
        }

        .course-name {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .course-stats {
            display: flex;
            gap: 20px;
            font-size: 0.8rem;
            flex-wrap: wrap;
        }

        .course-stats span {
            color: var(--gray);
        }

        .course-stats strong {
            color: var(--primary);
            font-weight: 700;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: var(--secondary-light);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        /* Top Members Section - Light Theme */
        .top-members-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            margin-top: 30px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, white, #fafafa);
        }

        .section-header h3 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .section-header h3 i {
            color: var(--primary);
        }

        .members-list {
            padding: 20px;
        }

        .top-member {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .top-member:last-child {
            border-bottom: none;
        }

        .top-member:hover {
            background: var(--primary-light);
            transform: translateX(5px);
            border-radius: 10px;
        }

        .member-rank {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            width: 50px;
            text-align: center;
        }

        .member-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .member-avatar {
            width: 50px;
            height: 50px;
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
            font-size: 1.5rem;
            color: var(--primary);
        }

        .member-details h4 {
            color: var(--dark);
            margin: 0 0 3px 0;
            font-size: 1rem;
        }

        .member-details p {
            color: var(--gray);
            margin: 0;
            font-size: 0.75rem;
        }

        .member-details p i {
            color: var(--primary);
            margin-right: 3px;
        }

        .member-stats {
            text-align: right;
        }

        .member-stats .classes {
            color: var(--dark);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .member-stats .rate {
            color: var(--success);
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .charts-grid {
                gap: 20px;
            }
        }

        @media (max-width: 992px) {
            .statistics-container {
                padding: 20px;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .statistics-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .date-form {
                flex-direction: column;
            }

            .date-group {
                width: 100%;
            }

            .btn-apply,
            .btn-export {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                gap: 15px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 2rem;
            }

            .top-member {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .member-info {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .member-stats {
                text-align: center;
            }

            .member-rank {
                width: auto;
            }

            .course-item {
                flex-direction: column;
                text-align: center;
            }

            .course-stats {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .statistics-container {
                padding: 10px;
            }

            .page-header h1 {
                font-size: 1.3rem;
            }

            .date-range-card {
                padding: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 1.8rem;
            }

            .chart-header {
                padding: 15px;
            }

            .chart-body {
                padding: 15px;
            }

            .chart-container {
                height: 250px;
            }

            .members-list {
                padding: 15px;
            }

            .top-member {
                padding: 12px;
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
        .chart-card,
        .top-members-section {
            animation: fadeInUp 0.4s ease forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.2s;
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
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
        }

        /* Tooltip */
        [data-tooltip] {
            position: relative;
            cursor: help;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 5px;
            display: none;
        }

        [data-tooltip]:hover:before {
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="statistics-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-chart-line"></i>
                My Statistics & Analytics
            </h1>
        </div>

        <!-- Date Range Filter -->
        <div class="date-range-card">
            <form method="GET" action="{{ route('trainer.statistics') }}" class="date-form">
                <div class="date-group">
                    <label><i class="fas fa-calendar-alt"></i> Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="date-group">
                    <label><i class="fas fa-calendar-alt"></i> End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="date-group">
                    <button type="submit" class="btn-apply">
                        <i class="fas fa-chart-line"></i> Apply Range
                    </button>
                </div>
            </form>
        </div>

        <!-- Key Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-value">{{ $classesStats->total ?? 0 }}</div>
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <div class="stat-label">Total Classes</div>
                <div class="stat-trend">
                    <span>Total capacity: {{ $classesStats->total_capacity ?? 0 }}</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-value">{{ $attendanceStats->total ?? 0 }}</div>
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-label">Total Attendances</div>
                <div class="stat-trend">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i>
                        Present: {{ $attendanceStats->present ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    @php
                        $attendanceRate =
                            $attendanceStats->total > 0
                                ? round(($attendanceStats->present / $attendanceStats->total) * 100)
                                : 0;
                    @endphp
                    <div class="stat-value">{{ $attendanceRate }}%</div>
                    <i class="fas fa-percent"></i>
                </div>
                <div class="stat-label">Attendance Rate</div>
                <div class="stat-trend">
                    <span>Absent: {{ $attendanceStats->absent ?? 0 }}</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    @php
                        $avgClassSize =
                            $classesStats->total > 0 ? round(($attendanceStats->total ?? 0) / $classesStats->total) : 0;
                    @endphp
                    <div class="stat-value">{{ $avgClassSize }}</div>
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Average Class Size</div>
                <div class="stat-trend">
                    <span>Per class session</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <!-- Daily Trend Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3><i class="fas fa-chart-line"></i> Daily Attendance Trend</h3>
                </div>
                <div class="chart-body">
                    <div class="chart-container">
                        <canvas id="dailyTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Course Distribution Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3><i class="fas fa-chart-pie"></i> Classes by Course</h3>
                </div>
                <div class="chart-body">
                    <div class="chart-container">
                        <canvas id="courseDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Breakdown -->
        <div class="chart-card" style="margin-bottom: 30px;">
            <div class="chart-header">
                <h3><i class="fas fa-dumbbell"></i> Course Performance Breakdown</h3>
            </div>
            <div class="chart-body">
                <div class="course-list">
                    @forelse($courseBreakdown as $course)
                        @php
                            $attendanceRate =
                                $course->classes > 0
                                    ? round(($course->present / ($course->total_attendees ?: 1)) * 100)
                                    : 0;
                        @endphp
                        <div class="course-item">
                            <div class="course-icon">
                                <i class="fas fa-running"></i>
                            </div>
                            <div class="course-info">
                                <div class="course-name">{{ $course->course_name }}</div>
                                <div class="course-stats">
                                    <span><strong>{{ $course->classes }}</strong> Classes</span>
                                    <span><strong>{{ $course->total_attendees ?? 0 }}</strong> Total Attendees</span>
                                    <span><strong>{{ $course->present ?? 0 }}</strong> Present</span>
                                </div>
                                <div class="progress-bar" style="margin-top: 8px;">
                                    <div class="progress-fill" style="width: {{ $attendanceRate }}%"></div>
                                </div>
                            </div>
                            <div class="course-stats">
                                <span style="color: var(--success); font-weight: 600;">{{ $attendanceRate }}%</span>
                            </div>
                        </div>
                    @empty
                        <p style="color: var(--gray-light); text-align: center;">No course data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Members Section -->
        <div class="top-members-section">
            <div class="section-header">
                <h3><i class="fas fa-trophy"></i> Top Attending Members</h3>
            </div>
            <div class="members-list">
                @php
                    $topMembers = collect();
                    // Calculate top members from attendance data
                    // This would come from your controller ideally
                @endphp

                @if ($topMembers->count() > 0)
                    @foreach ($topMembers as $index => $member)
                        <div class="top-member">
                            <div class="member-rank">#{{ $index + 1 }}</div>
                            <div class="member-info">
                                <div class="member-avatar">
                                    @if ($member->photo)
                                        <img src="{{ asset('admin/uploads/' . $member->photo) }}"
                                            alt="{{ $member->name }}">
                                    @else
                                        <i class="fas fa-user-circle"></i>
                                    @endif
                                </div>
                                <div class="member-details">
                                    <h4>{{ $member->name }}</h4>
                                    <p>{{ $member->email ?? '' }}</p>
                                </div>
                            </div>
                            <div class="member-stats">
                                <div class="classes">{{ $member->classes_attended }} Classes</div>
                                <div class="rate">{{ $member->attendance_rate }}% Attendance</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="color: var(--gray-light); text-align: center; padding: 40px;">
                        <i class="fas fa-info-circle"></i> No member data available for this period
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Daily Trend Chart
        const dailyTrendCtx = document.getElementById('dailyTrendChart').getContext('2d');
        const dailyTrendData = @json($dailyTrend);

        new Chart(dailyTrendCtx, {
            type: 'line',
            data: {
                labels: dailyTrendData.map(item => item.start_date),
                datasets: [{
                    label: 'Classes',
                    data: dailyTrendData.map(item => item.classes),
                    borderColor: '#ff5500',
                    backgroundColor: 'rgba(255, 85, 0, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Attendees',
                    data: dailyTrendData.map(item => item.attendees),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff'
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#fff'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#fff'
                        }
                    }
                }
            }
        });

        // Course Distribution Chart
        const courseDistCtx = document.getElementById('courseDistributionChart').getContext('2d');
        const courseData = @json($courseBreakdown);

        new Chart(courseDistCtx, {
            type: 'doughnut',
            data: {
                labels: courseData.map(course => course.course_name),
                datasets: [{
                    data: courseData.map(course => course.classes),
                    backgroundColor: ['#ff5500', '#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6f42c1'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff'
                        }
                    }
                }
            }
        });
    </script>
@endsection
