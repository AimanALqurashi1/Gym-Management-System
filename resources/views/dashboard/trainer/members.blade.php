@extends('layouts.home')

@section('title', 'My Members')

@section('css')
    <style>
        /* Members Container - Light Theme */
        .members-container {
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

        /* Stats Cards - Light Theme */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
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

        .stat-icon.active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.attendance {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
        }

        .stat-icon.expiring {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 1.8rem;
            margin: 0;
            font-weight: 700;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Filters Card - Light Theme */
        .filters-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filters-row {
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

        .filter-group input,
        .filter-group select {
            width: 100%;
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 12px;
            color: var(--dark);
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition);
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .btn-search {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-reset {
            background: var(--gray);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reset:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        /* Members Table - Light Theme */
        .members-table-wrapper {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .members-table {
            width: 100%;
            border-collapse: collapse;
        }

        .members-table thead {
            background: var(--primary);
        }

        .members-table th {
            color: white;
            font-weight: 700;
            padding: 15px;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Montserrat', sans-serif;
        }

        .members-table td {
            padding: 15px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .members-table tbody tr {
            transition: var(--transition);
        }

        .members-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Member Info - Light Theme */
        .member-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-avatar {
            width: 45px;
            height: 45px;
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
            margin: 0 0 3px 0;
            font-size: 1rem;
            color: var(--dark);
        }

        .member-details p {
            margin: 0;
            color: var(--gray);
            font-size: 0.8rem;
        }

        .member-details p i {
            color: var(--primary);
            margin-right: 3px;
        }

        /* Attendance Rate - Light Theme */
        .attendance-rate {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rate-bar {
            width: 80px;
            height: 6px;
            background: var(--secondary-light);
            border-radius: 3px;
            overflow: hidden;
        }

        .rate-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .rate-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
        }

        /* Status Badges - Light Theme */
        .badge-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-active {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .badge-inactive {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .badge-pending {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .badge-expired {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-view {
            background: var(--primary);
            color: white;
            border: none;
            padding: 6px 14px;
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
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-edit {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--dark);
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* Pagination - Light Theme */
        .pagination-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination {
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

        /* Empty State - Light Theme */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
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

        /* Add Member Button */
        .btn-add {
            background: var(--success);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .btn-add:hover {
            background: var(--success-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* Export Button */
        .btn-export {
            background: var(--info);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-export:hover {
            background: #138496;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .members-container {
                padding: 20px;
            }

            .stats-cards {
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .members-container {
                padding: 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-add,
            .btn-export {
                width: 100%;
                justify-content: center;
            }

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .filters-row {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-search,
            .btn-reset {
                width: 100%;
                justify-content: center;
            }

            .members-table th,
            .members-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .member-info {
                flex-direction: column;
                text-align: center;
            }

            .attendance-rate {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-view,
            .btn-edit {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .members-container {
                padding: 10px;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .stat-info h3 {
                font-size: 1.5rem;
            }

            .member-avatar {
                width: 40px;
                height: 40px;
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
        .filters-card,
        .members-table-wrapper {
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
    <div class="members-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-users"></i>
                My Members
            </h1>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $members->total() }}</h3>
                    <p>Total Members</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon active">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>
                        @php
                            $activeMembers = $members
                                ->filter(function ($member) {
                                    return ($member->total_classes ?? 0) > 0;
                                })
                                ->count();
                        @endphp
                        {{ $activeMembers }}
                    </h3>
                    <p>Active Members</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon attendance">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>
                        @php
                            $avgAttendance = $members->avg(function ($member) {
                                return $member->total_classes > 0
                                    ? ($member->attended_classes / $member->total_classes) * 100
                                    : 0;
                            });
                        @endphp
                        {{ round($avgAttendance) }}%
                    </h3>
                    <p>Avg Attendance Rate</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <form method="GET" action="{{ route('trainer.members') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label><i class="fas fa-search"></i> Search</label>
                        <input type="text" name="search" placeholder="Search by name or email..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="filter-group">
                        <label><i class="fas fa-calendar"></i> Sort By</label>
                        <select name="sort">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="classes" {{ request('sort') == 'classes' ? 'selected' : '' }}>Most Classes
                            </option>
                            <option value="attendance" {{ request('sort') == 'attendance' ? 'selected' : '' }}>Highest
                                Attendance</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Members Table -->
        <div class="members-table-wrapper">
            @if ($members->count() > 0)
                <table class="members-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Contact</th>
                            <th>Total Classes</th>
                            <th>Attended</th>
                            <th>Attendance Rate</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            @php
                                $attendanceRate =
                                    $member->total_classes > 0
                                        ? round(($member->attended_classes / $member->total_classes) * 100)
                                        : 0;

                                $statusClass = $attendanceRate >= 75 ? 'badge-active' : 'badge-inactive';
                                $statusText = $attendanceRate >= 75 ? 'Active' : 'Inactive';
                            @endphp
                            <tr>
                                <td>
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
                                            <p>ID: {{ $member->code ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        <div><i class="fas fa-envelope"></i> {{ $member->email ?? 'N/A' }}</div>
                                        <div><i class="fas fa-phone"></i> {{ $member->phone ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color: var(--primary);">{{ $member->total_classes ?? 0 }}</strong>
                                </td>
                                <td>
                                    <strong style="color: var(--success);">{{ $member->attended_classes ?? 0 }}</strong>
                                </td>
                                <td>
                                    <div class="attendance-rate">
                                        <div class="rate-bar">
                                            <div class="rate-fill" style="width: {{ $attendanceRate }}%"></div>
                                        </div>
                                        <span class="rate-text">{{ $attendanceRate }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-status {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>
                                    {{-- <a href="{{ route('member.details', $member->id) ?? '#' }}" class="btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a> --}}

                                    <a href="#" class="btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination-container">
                    {{ $members->appends(request()->query())->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-user-friends"></i>
                    <h3>No Members Found</h3>
                    <p>You haven't trained any members yet. Once members attend your classes, they'll appear here.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Add any JavaScript for filtering if needed
        document.querySelectorAll('.filter-group select, .filter-group input').forEach(element => {
            element.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
@endsection
