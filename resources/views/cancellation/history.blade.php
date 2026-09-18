@extends('layouts.home')

@section('title', 'Cancellation History')

@section('css')
    <style>
        /* History Container - Light Theme */
        .history-container {
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

        /* ADDED: Filter Section */
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

        /* Cancellation Table - Light Theme */
        .cancellation-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .cancellation-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
        }

        .cancellation-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            vertical-align: middle;
        }

        .cancellation-table tbody tr:hover {
            background: var(--primary-light);
        }

        .cancellation-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Refund Badge - Light Theme */
        .refund-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .refund-yes {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .refund-no {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .refund-partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        /* Button View - Light Theme */
        .btn-view {
            background: var(--primary);
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-view:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* ADDED: Refund Amount Column */
        .refund-amount {
            font-weight: 600;
            color: var(--primary);
        }

        .refund-amount.zero {
            color: var(--gray);
        }

        /* ADDED: Cancellation Reason Preview */
        .reason-preview {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--gray);
        }

        .reason-full {
            cursor: pointer;
            color: var(--primary);
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .reason-full:hover {
            text-decoration: underline;
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

        /* Responsive */
        @media (max-width: 768px) {
            .history-container {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card h3 {
                font-size: 1.4rem;
            }

            .cancellation-table {
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
        }

        @media (max-width: 576px) {
            .history-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .cancellation-table th,
            .cancellation-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .refund-badge {
                padding: 2px 8px;
                font-size: 0.65rem;
            }

            .btn-view {
                padding: 3px 8px;
                font-size: 0.7rem;
            }

            .reason-preview {
                max-width: 120px;
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

        .cancellation-table tbody tr {
            animation: fadeIn 0.2s ease forwards;
        }

        /* Modal for refund details */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: var(--border-radius);
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            color: var(--dark);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endsection

@section('content')
    <div class="history-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-history"></i>
                Cancellation History
            </h1>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $stats['total_cancelled'] }}</h3>
                <p>Total Cancellations</p>
            </div>
            <div class="stat-card">
                <h3>${{ number_format($stats['total_refunded'], 2) }}</h3>
                <p>Total Refunded</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['cancelled_this_month'] }}</h3>
                <p>This Month</p>
            </div>
        </div>

        <table class="cancellation-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Course</th>
                    <th>Amount Paid</th>
                    <th>Refund Amount</th>
                    <th>Refund %</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cancellations as $cancellation)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($cancellation->cancelled_at)->format('M d, Y') }}</td>
                        <td>{{ $cancellation->member->name ?? 'N/A' }}</td>
                        <td>{{ $cancellation->schedule->course->name ?? 'N/A' }}</td>
                        <td>${{ number_format($cancellation->amount_paid, 2) }}</td>
                        <td>${{ number_format($cancellation->refund_amount, 2) }}</td>
                        <td>
                            @if ($cancellation->refund_amount > 0)
                                <span class="refund-badge refund-yes">
                                    {{ round(($cancellation->refund_amount / $cancellation->amount_paid) * 100) }}%
                                </span>
                            @else
                                <span class="refund-badge refund-no">0%</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($cancellation->cancellation_reason, 30) }}</td>
                        <td>
                            <a href="#" class="btn-view">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No cancellation records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $cancellations->links() }}
        </div>
    </div>
@endsection
