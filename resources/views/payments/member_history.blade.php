@extends('layouts.home')

@section('title', 'Payment History - ' . $member->name)

@section('css')
    <style>
        /* History Container - Light Theme */
        .history-container {
            padding: 30px;
        }

        /* Member Header - Light Theme */
        .member-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .member-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar i {
            font-size: 2.5rem;
            color: white;
        }

        .member-info h2 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .member-info p {
            color: var(--gray);
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .member-info p i {
            color: var(--primary);
        }

        /* ADDED: Payment Status Section */
        .payment-status-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .payment-status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        .payment-details {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .payment-detail {
            text-align: center;
        }

        .payment-detail .label {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .payment-detail .value {
            color: var(--dark);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .payment-detail .value.text-danger {
            color: var(--danger);
        }

        .btn-payment-history {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(255, 85, 0, 0.2);
        }

        .btn-payment-history:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
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

        /* ADDED: Receipt Image Thumbnail */
        .receipt-thumbnail {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            background: #f5f5f5;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .receipt-thumbnail:hover {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .receipt-thumbnail i {
            font-size: 1.2rem;
            color: var(--primary);
        }

        .receipt-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
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

        /* Button Icon - Light Theme */
        .btn-icon {
            background: transparent;
            border: none;
            color: var(--gray);
            padding: 5px 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px;
            color: var(--gray);
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .history-container {
                padding: 20px;
            }

            .member-header {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .member-info h2 {
                font-size: 1.5rem;
            }

            .member-info p {
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card h3 {
                font-size: 1.4rem;
            }

            .payment-status-section {
                flex-direction: column;
                text-align: center;
            }

            .payment-details {
                justify-content: center;
            }

            .payments-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 576px) {
            .history-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .payments-table th,
            .payments-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .payment-details {
                gap: 15px;
            }

            .payment-detail .value {
                font-size: 1rem;
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

        .stat-card,
        .payments-table {
            animation: fadeIn 0.3s ease forwards;
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
    <div class="history-container">
        <div class="member-header">
            <div class="member-avatar">
                @if ($member->photo)
                    <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}">
                @else
                    <i class="fas fa-user-circle" style="font-size: 3rem; color: white;"></i>
                @endif
            </div>
            <div class="member-info">
                <h2>{{ $member->name }}</h2>
                <p><i class="fas fa-id-card"></i> Code: {{ $member->code ?? 'N/A' }}</p>
                <p><i class="fas fa-envelope"></i> {{ $member->email ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>${{ number_format($stats['total_paid'], 2) }}</h3>
                <p>Total Paid</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($stats['total_refunded'], 2) }}</h3>
                <p>Total Refunded</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($stats['current_balance'], 2) }}</h3>
                <p>Current Balance</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['last_payment'] ? $stats['last_payment']->payment_date->format('M d, Y') : 'N/A' }}</h3>
                <p>Last Payment</p>
            </div>
        </div>

        <h3 style="color: white; margin-bottom: 20px;">Payment History</h3>

        <table class="payments-table">
            <thead>
                <tr>
                    <th>Receipt #</th>
                    <th>Date</th>
                    <th>Period</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->receipt_number }}</td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td>
                            {{ $payment->period_start_date->format('M d') }} -
                            {{ $payment->period_end_date->format('M d, Y') }}
                        </td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span
                                class="status-badge status-{{ $payment->status == 'paid' ? 'paid' : ($payment->status == 'refunded' ? 'refunded' : 'partial') }}">
                                {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('payments.receipt.download', $payment->id) }}" class="btn-icon"
                                title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            No payment records found
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
