@extends('layouts.home')

@section('title', 'Cancel Enrollments')

@section('css')
    <style>
        /* Cancel Manage Container - Light Theme */
        .cancel-manage-container {
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

        .stat-card h3 {
            color: var(--dark);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--gray);
            margin: 0;
        }

        /* Search Section - Light Theme */
        .search-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .search-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .search-group {
            flex: 1;
            min-width: 200px;
        }

        .search-group label {
            display: block;
            color: var(--gray);
            margin-bottom: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .search-group input,
        .search-group select {
            width: 100%;
            padding: 10px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            transition: var(--transition);
        }

        .search-group input:focus,
        .search-group select:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Button Search - Light Theme */
        .btn-search {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            cursor: pointer;
            height: 42px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-search:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Enrollments Table - Light Theme */
        .enrollments-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .enrollments-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            font-weight: 600;
            padding: 15px;
            text-align: left;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .enrollments-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            vertical-align: middle;
        }

        .enrollments-table tbody tr {
            transition: var(--transition);
        }

        .enrollments-table tbody tr:hover {
            background: var(--primary-light);
        }

        .enrollments-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Member Cell - Light Theme */
        .member-cell .name {
            font-weight: 600;
            color: var(--dark);
        }

        .member-cell .code {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .course-name {
            font-weight: 500;
            color: var(--dark);
        }

        /* Amount Colors - Light Theme */
        .price {
            color: var(--primary);
            font-weight: 600;
        }

        .paid {
            color: var(--success);
            font-weight: 600;
        }

        .remaining {
            color: var(--warning);
            font-weight: 600;
        }

        /* Status Badge - Light Theme */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        /* Refund Badge - Light Theme */
        .refund-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .refund-100 {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .refund-50 {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .refund-0 {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Days Info - Light Theme */
        .days-info {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .days-warning {
            color: var(--warning);
        }

        .days-danger {
            color: var(--danger);
        }

        .days-success {
            color: var(--success);
        }

        /* Buttons - Light Theme */
        .btn-cancel {
            background: var(--danger);
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.2);
        }

        .btn-cancel:hover {
            background: #bd2130;
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-view {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-left: 8px;
            transition: var(--transition);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* No Data - Light Theme */
        .no-data {
            text-align: center;
            padding: 60px;
            color: var(--gray);
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
            opacity: 0.5;
            color: var(--primary);
        }

        /* ADDED: Refund Preview Tooltip */
        .refund-preview {
            cursor: help;
            border-bottom: 1px dashed var(--primary);
        }

        .refund-preview:hover {
            position: relative;
        }

        .refund-preview:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cancel-manage-container {
                padding: 20px;
            }

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card h3 {
                font-size: 1.4rem;
            }

            .enrollments-table {
                display: block;
                overflow-x: auto;
            }

            .search-form {
                flex-direction: column;
            }

            .search-group {
                width: 100%;
            }

            .btn-search {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .cancel-manage-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .enrollments-table th,
            .enrollments-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .btn-cancel,
            .btn-view {
                padding: 4px 10px;
                font-size: 0.7rem;
            }

            .member-cell .name {
                font-size: 0.9rem;
            }

            .refund-badge {
                padding: 2px 8px;
                font-size: 0.6rem;
            }
        }

        /* Animation for table rows */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .enrollments-table tbody tr {
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
    <div class="cancel-manage-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-ban"></i>
                Cancel Enrollments
            </h1>
        </div>

        <!-- Statistics Cards -->
        @php
            $totalActive = App\Models\MemberSchedule::where('status', 'active')->count();
            $totalPaid = App\Models\MemberSchedule::where('status', 'active')->sum('amount_paid');
            $totalDue = App\Models\MemberSchedule::where('status', 'active')->sum('amount_due');
        @endphp

        <div class="stats-cards">
            <div class="stat-card">
                <h3>{{ $totalActive }}</h3>
                <p>Active Enrollments</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($totalPaid, 2) }}</h3>
                <p>Total Collected</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($totalDue, 2) }}</h3>
                <p>Total Due</p>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('cancellation.manage') }}" method="GET" class="search-form">
                <div class="search-group">
                    <label>Search Member</label>
                    <input type="text" name="search" placeholder="Name or code..." value="{{ request('search') }}">
                </div>
                <div class="search-group">
                    <label>Course</label>
                    <select name="course_id">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="search-group">
                    <label>Payment Status</label>
                    <select name="payment_status">
                        <option value="">All</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial
                        </option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('cancellation.manage') }}" class="btn-search" style="background: var(--gray);">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </form>
        </div>

        <!-- Enrollments Table -->
        <table class="enrollments-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Course</th>
                    <th>Schedule</th>
                    <th>Total Amount</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                    <th>Days Active</th>
                    <th>Refund Eligibility</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    @php
                        $enrolledDate = \Carbon\Carbon::parse($enrollment->enrolled_date);
                        $today = \Carbon\Carbon::now();
                        $daysActive = $enrolledDate->diffInDays($today);

                        $expiryDate = \Carbon\Carbon::parse($enrollment->expiry_date);
                        $totalPeriodDays = $expiryDate->diffInDays($enrolledDate);
                        $halfPeriodDays = round($totalPeriodDays / 2);

                        $refundPercentage = 0;
                        $refundClass = '';
                        $refundText = '';

                        if ($daysActive <= 2) {
                            $refundPercentage = 100;
                            $refundClass = 'refund-100';
                            $refundText = '100% Refund';
                        } elseif ($daysActive <= $halfPeriodDays) {
                            $refundPercentage = 50;
                            $refundClass = 'refund-50';
                            $refundText = '50% Refund';
                        } else {
                            $refundPercentage = 0;
                            $refundClass = 'refund-0';
                            $refundText = 'No Refund';
                        }

                        $daysClass = '';
                        if ($daysActive <= 2) {
                            $daysClass = '';
                        } elseif ($daysActive <= $halfPeriodDays) {
                            $daysClass = 'days-warning';
                        } else {
                            $daysClass = 'days-danger';
                        }

                        $remaining = $enrollment->total_amount - $enrollment->amount_paid;
                    @endphp
                    <tr>
                        <td>
                            <div class="member-cell">
                                <div class="name">{{ $enrollment->member->name ?? 'N/A' }}</div>
                                <div class="code">{{ $enrollment->member->code ?? 'No Code' }}</div>
                            </div>
    </div>
    <td class="course-name">{{ $enrollment->schedule->course->name ?? 'N/A' }}</div>
    <td>
        {{ ucfirst($enrollment->schedule->day_of_week ?? '') }}<br>
        <small>{{ \Carbon\Carbon::parse($enrollment->schedule->start_time ?? '')->format('g:i A') }}</small>
    </td>
    <td class="price">${{ number_format($enrollment->total_amount, 2) }}</div>
    <td class="paid">${{ number_format($enrollment->amount_paid, 2) }}</div>
    <td class="remaining">${{ number_format($remaining, 2) }}</div>
    <td>
        {{-- <span class="{{ $daysClass }}">{{ $daysActive }} days</span> --}}
        <div class="days-info">Half period: {{ $halfPeriodDays }} days</div>
    </td>
    <td>
        <span class="refund-badge {{ $refundClass }}">
            {{ $refundText }}
        </span>
        @if ($refundPercentage > 0)
            <div class="days-info" style="margin-top: 5px;">
                Refund: ${{ number_format(($enrollment->amount_paid * $refundPercentage) / 100, 2) }}
            </div>
        @endif
    </td>
    <td>
        <a href="{{ route('cancellation.form', $enrollment->id) }}" class="btn-cancel">
            <i class="fas fa-ban"></i> Cancel
        </a>
        <a href="{{ route('cancellation.refund.preview', $enrollment->id) }}" class="btn-view">
            <i class="fas fa-calculator"></i> Preview
        </a>
    </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="no-data">
            <i class="fas fa-calendar-times"></i>
            No active enrollments found.
        </td>
    </tr>
    @endforelse
    </tbody>
    </table>

    <div class="pagination">
        {{ $enrollments->appends(request()->query())->links() }}
    </div>
    </div>
@endsection
