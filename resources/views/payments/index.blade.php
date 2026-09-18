@extends('layouts.home')

@section('title', 'Payment Management')

@section('css')
    <style>
        /* Payments Container - Light Theme */
        .payments-container {
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

        .stat-card h3 {
            color: var(--dark);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--gray);
            margin: 0;
        }

        /* Filters Section - Light Theme */
        .filters-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filters-form {
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

        .filter-select,
        .filter-input {
            width: 100%;
            padding: 10px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            transition: var(--transition);
        }

        .filter-select:focus,
        .filter-input:focus {
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
            cursor: pointer;
            height: 42px;
            transition: var(--transition);
            font-weight: 600;
        }

        .btn-filter:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Payments Table - Light Theme */
        .payments-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .payments-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .payments-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
        }

        .payments-table tbody tr:hover {
            background: var(--primary-light);
        }

        .payments-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badge - Light Theme */
        .status-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-refunded {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .status-partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        /* Buttons - Light Theme */
        .btn-icon {
            background: transparent;
            border: none;
            color: var(--gray);
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(255, 85, 0, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
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

        /* Pagination - Light Theme */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* ADDED: Receipt Image Styles */
        .receipt-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .receipt-image:hover {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        /* Payment Details Card */
        .payment-details-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .payment-details-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            padding: 20px 25px;
            border-bottom: 2px solid var(--primary);
        }

        .payment-details-header h2 {
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-details-body {
            padding: 25px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payments-container {
                padding: 20px;
            }

            .filters-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filter {
                width: 100%;
            }

            .payments-table {
                display: block;
                overflow-x: auto;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card h3 {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .payments-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .payments-table th,
            .payments-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .btn-icon {
                padding: 3px 6px;
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

        .payments-table tbody tr {
            animation: fadeIn 0.2s ease forwards;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Loading state */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="payments-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-dollar-sign"></i>
                Payment Management
            </h1>
            <a href="{{ route('payments.payment_list') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                Record Payment
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>${{ number_format($stats['total_payments'], 2) }}</h3>
                <p>Total Payments</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($stats['total_refunds'], 2) }}</h3>
                <p>Total Refunds</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($stats['net_revenue'], 2) }}</h3>
                <p>Net Revenue</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($stats['payments_this_month'], 2) }}</h3>
                <p>This Month</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-section">
            <form action="{{ route('payments.index') }}" method="GET" class="filters-form">
                <div class="filter-group">
                    <label>Member</label>
                    <select name="member_id" class="filter-select">
                        <option value="">All Members</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-select">
                        <option value="all">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        <option value="partial_refund" {{ request('status') == 'partial_refund' ? 'selected' : '' }}>
                            Partial Refund</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Filter
                </button>

                <a href="{{ route('payments.index') }}" class="btn-filter" style="background: var(--gray);">
                    <i class="fas fa-undo"></i> Clear
                </a>
            </form>
        </div>

        <!-- Payments Table -->
        <table class="payments-table">
            <thead>
                <tr>
                    <th>Receipt #</th>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    {{-- <th>Period</th> --}}
                    <th>Status</th>
                    <th>Recorded By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->receipt_number }}</td>
                        <td>{{ $payment->member->name ?? 'N/A' }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        {{-- <td>
                            {{ $payment->period_start_date->format('M d') }} -
                            {{ $payment->period_end_date->format('M d, Y') }}
                        </td> --}}
                        <td>
                            <span
                                class="status-badge status-{{ $payment->status == 'paid' ? 'paid' : ($payment->status == 'refunded' ? 'refunded' : 'partial') }}">
                                {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                            </span>
                        </td>
                        <td>{{ $payment->recorder->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('payments.receipt.download', $payment->id) }}" class="btn-icon"
                                title="Download Receipt">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="{{ route('payments.receipt.view', $payment->id) }}" class="btn-icon"
                                title="View Receipt" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            <i class="fas fa-info-circle"></i> No payments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $payments->links() }}
        </div>
    </div>
@endsection
