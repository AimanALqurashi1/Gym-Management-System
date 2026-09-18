{{-- resources/views/payments/table_payment.blade.php --}}
@extends('layouts.home')

@section('title', 'Payment Management')

@section('css')
    <style>
        /* Payment Container - Light Theme */
        .payment-container {
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

        /* Payment Table - Light Theme */
        .payment-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .payment-table thead tr {
            background: rgba(0, 0, 0, 0.02);
        }

        .payment-table th {
            padding: 15px;
            text-align: left;
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .payment-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            vertical-align: middle;
        }

        .payment-table tbody tr {
            transition: var(--transition);
            cursor: pointer;
        }

        .payment-table tbody tr:hover {
            background: var(--primary-light);
        }

        .payment-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Total Row Styles - Light Theme */
        .total-row {
            background: linear-gradient(135deg, var(--primary-light), white);
            border-top: 2px solid var(--primary);
            font-weight: 700;
        }

        .total-row td {
            padding: 18px 15px;
            font-weight: 700;
        }

        .total-label {
            text-align: right;
            font-size: 1.1rem;
            color: var(--dark);
        }

        .total-amount {
            font-size: 1.2rem;
            color: var(--primary);
        }

        /* Member Info - Light Theme */
        .member-name {
            font-weight: 600;
            color: var(--dark);
        }

        .member-code {
            font-size: 0.8rem;
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

        .status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .status-pending {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .status-overdue {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Button Pay - Light Theme */
        .btn-pay {
            background: var(--primary);
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
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-pay:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
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

        /* ADDED: Filter Section - Light Theme */
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
            margin-bottom: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            padding: 10px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            transition: var(--transition);
        }

        .filter-input:focus,
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
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            height: 42px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-filter:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-reset {
            background: var(--gray);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            height: 42px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-reset:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-container {
                padding: 20px;
            }

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card h3 {
                font-size: 1.4rem;
            }

            .payment-table {
                display: block;
                overflow-x: auto;
            }

            .filter-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filter,
            .btn-reset {
                width: 100%;
            }

            .total-label {
                font-size: 0.9rem;
            }

            .total-amount {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .payment-container {
                padding: 15px;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .payment-table th,
            .payment-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .btn-pay {
                padding: 4px 10px;
                font-size: 0.7rem;
            }

            .total-row td {
                padding: 12px 10px;
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

        .payment-table tbody tr {
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
    <div class="payment-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-credit-card"></i>
                Payment Management
            </h1>
        </div>

        <!-- Statistics Cards -->
        @php
            $totalPending = App\Models\MemberSchedule::where('payment_status', 'pending')->count();
            $totalPartial = App\Models\MemberSchedule::where('payment_status', 'partial')->count();
            $totalOverdue = App\Models\MemberSchedule::where('payment_status', 'overdue')->count();
            $totalPaid = App\Models\MemberSchedule::where('payment_status', 'paid')->count();
            $totalCollected = App\Models\Payment::sum('amount');
        @endphp

        <div class="stats-cards">
            <div class="stat-card">
                <h3 style="color: var(--warning);">{{ $totalPending }}</h3>
                <p>Pending Payments</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--warning);">{{ $totalPartial }}</h3>
                <p>Partial Payments</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--danger);">{{ $totalOverdue }}</h3>
                <p>Overdue Payments</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--success);">${{ number_format($totalCollected, 2) }}</h3>
                <p>Total Collected</p>
            </div>
        </div>

        <!-- Payment Table -->
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Course</th>
                    <th>Trainer</th>
                    <th>Schedule</th>
                    <th>Total Amount</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Calculate totals for the footer
                    $grandTotalAmount = 0;
                    $grandTotalPaid = 0;
                    $grandTotalRemaining = 0;
                @endphp

                @forelse($need_to_pay as $enrollment)
                    @php
                        $remaining = $enrollment->total_amount - $enrollment->amount_paid;

                        // Add to grand totals
                        $grandTotalAmount += $enrollment->total_amount;
                        $grandTotalPaid += $enrollment->amount_paid;
                        $grandTotalRemaining += $remaining;

                        $statusClass = '';
                        $statusText = ucfirst($enrollment->payment_status);

                        switch ($enrollment->payment_status) {
                            case 'paid':
                                $statusClass = 'status-paid';
                                break;
                            case 'partial':
                                $statusClass = 'status-partial';
                                break;
                            case 'pending':
                                $statusClass = 'status-pending';
                                break;
                            case 'overdue':
                                $statusClass = 'status-overdue';
                                break;
                            default:
                                $statusClass = 'status-pending';
                        }
                    @endphp
                    <tr
                        onclick="window.location.href='{{ route('payments.create_payment', [$enrollment->member->id, $enrollment->id]) }}'">
                        <td>
                            <div class="member-name">{{ $enrollment->member->name ?? 'N/A' }}</div>
                            <div class="member-code">{{ $enrollment->member->code ?? 'No Code' }}</div>
                        </td>
                        <td class="course-name">{{ $enrollment->schedule->course->name ?? 'N/A' }}</td>
                        <td>{{ $enrollment->schedule->trainer->name ?? 'N/A' }}</td>
                        <td>
                            {{ ucfirst($enrollment->schedule->day_of_week ?? '') }}<br>
                            <small>{{ \Carbon\Carbon::parse($enrollment->schedule->start_time ?? '')->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($enrollment->schedule->end_time ?? '')->format('g:i A') }}</small>
                        </td>
                        <td class="price">${{ number_format($enrollment->total_amount, 2) }}</td>
                        <td class="paid">${{ number_format($enrollment->amount_paid, 2) }}</td>
                        <td class="remaining">${{ number_format($remaining, 2) }}</td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td onclick="event.stopPropagation();">
                            <a href="{{ route('payments.create_payment', [$enrollment->member->id, $enrollment->id]) }}"
                                class="btn-pay">
                                <i class="fas fa-dollar-sign"></i> Pay Now
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-credit-card"></i>
                            No pending payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <!-- ADDED: Footer Total Row -->
            @if ($need_to_pay->count() > 0)
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" class="total-label">
                            <strong>GRAND TOTAL</strong>
                        </td>
                        <td class="price total-amount">
                            <strong>${{ number_format($grandTotalAmount, 2) }}</strong>
                        </td>
                        <td class="paid total-amount">
                            <strong>${{ number_format($grandTotalPaid, 2) }}</strong>
                        </td>
                        <td class="remaining total-amount">
                            <strong>${{ number_format($grandTotalRemaining, 2) }}</strong>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
@endsection
