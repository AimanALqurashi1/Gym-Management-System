@extends('layouts.home')

@section('title', 'Payment Details - ' . $payment->receipt_number)

@section('css')
    <style>
        /* Details Container - Light Theme */
        .details-container {
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Payment Card - Light Theme */
        .payment-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Card Header - Light Theme */
        .card-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            padding: 25px;
            border-bottom: 2px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
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

        /* Status Badge - Light Theme */
        .status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-refunded {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .status-partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        /* Card Body - Light Theme */
        .card-body {
            padding: 30px;
        }

        /* Info Grid - Light Theme */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .info-item:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .info-item .label {
            color: var(--gray);
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .info-item .value {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .info-item .value i {
            color: var(--primary);
            font-size: 1rem;
        }

        /* Amount Section - Light Theme */
        .amount-section {
            background: var(--primary-light);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            margin: 20px 0;
            border: 1px solid var(--border-primary);
        }

        .amount-section .label {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .amount-section .value {
            color: var(--primary);
            font-size: 2.5rem;
            font-weight: 700;
        }

        /* Course Details - Light Theme */
        .course-details {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid var(--border-color);
        }

        .course-details h4 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .course-details h4 i {
            color: var(--primary);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--gray);
        }

        .detail-value {
            color: var(--dark);
            font-weight: 500;
        }

        /* Action Buttons - Light Theme */
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
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

        /* Receipt Image - Light Theme */
        .receipt-image {
            margin-top: 20px;
            text-align: center;
        }

        .receipt-image img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .receipt-image img:hover {
            transform: scale(1.02);
            border-color: var(--primary);
        }

        /* ADDED: Refund Information Section */
        .refund-section {
            background: rgba(220, 53, 69, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid var(--danger);
        }

        .refund-section h4 {
            color: var(--danger);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .refund-section .refund-amount {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--danger);
        }

        /* ADDED: Timeline/History Section */
        .timeline-section {
            margin-top: 30px;
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .timeline-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 3px;
        }

        .timeline-date {
            color: var(--gray);
            font-size: 0.75rem;
        }

        .timeline-description {
            color: var(--gray);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .details-container {
                padding: 20px;
            }

            .card-body {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons a,
            .action-buttons button {
                width: 100%;
                justify-content: center;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (max-width: 576px) {
            .details-container {
                padding: 15px;
            }

            .card-header {
                padding: 15px;
            }

            .card-header h2 {
                font-size: 1.3rem;
            }

            .card-body {
                padding: 15px;
            }

            .amount-section .value {
                font-size: 2rem;
            }

            .info-item .value {
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

        .payment-card {
            animation: fadeIn 0.3s ease forwards;
        }

        .info-item {
            animation: fadeIn 0.3s ease forwards;
        }

        .info-item:nth-child(1) {
            animation-delay: 0s;
        }

        .info-item:nth-child(2) {
            animation-delay: 0.05s;
        }

        .info-item:nth-child(3) {
            animation-delay: 0.1s;
        }

        .info-item:nth-child(4) {
            animation-delay: 0.15s;
        }

        .info-item:nth-child(5) {
            animation-delay: 0.2s;
        }

        .info-item:nth-child(6) {
            animation-delay: 0.25s;
        }
    </style>
@endsection

@section('content')
    <div class="details-container">
        <div class="payment-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-receipt"></i>
                    Payment Details
                </h2>
                <span class="status-badge status-{{ $payment->status }}">
                    <i class="fas {{ $payment->status == 'paid' ? 'fa-check-circle' : 'fa-undo-alt' }}"></i>
                    {{ ucfirst($payment->status) }}
                </span>
            </div>

            <div class="card-body">
                <!-- Main Info Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="label">Receipt Number</div>
                        <div class="value">{{ $payment->receipt_number }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Payment Date</div>
                        <div class="value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('l, F j, Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Member Name</div>
                        <div class="value">{{ $payment->member->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Member Code</div>
                        <div class="value">{{ $payment->member->code ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label">Payment Method</div>
                        <div class="value">
                            <i class="fas fa-money-bill"></i> {{ ucfirst($payment->payment_method) }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="label">Recorded By</div>
                        <div class="value">{{ $payment->recorder->name ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Amount Section -->
                <div class="amount-section">
                    <div class="label">Amount Paid</div>
                    <div class="value">${{ number_format($payment->amount, 2) }}</div>
                </div>

                <!-- Course Details if available -->
                @if ($enrollment)
                    <div class="course-details">
                        <h4><i class="fas fa-book-open"></i> Course Information</h4>
                        <div class="detail-row">
                            <span class="detail-label">Course Name:</span>
                            <span class="detail-value">{{ $enrollment->schedule->course->name ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Trainer:</span>
                            <span class="detail-value">{{ $enrollment->schedule->trainer->name ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Schedule:</span>
                            <span class="detail-value">{{ ucfirst($enrollment->schedule->day_of_week ?? '') }} at
                                {{ \Carbon\Carbon::parse($enrollment->schedule->start_time ?? '')->format('g:i A') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total Amount:</span>
                            <span class="detail-value">${{ number_format($enrollment->total_amount, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Amount Paid:</span>
                            <span class="detail-value">${{ number_format($enrollment->amount_paid, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Remaining Balance:</span>
                            <span
                                class="detail-value">${{ number_format($enrollment->total_amount - $enrollment->amount_paid, 2) }}</span>
                        </div>
                    </div>
                @endif

                <!-- Notes if available -->
                @if ($payment->notes)
                    <div class="course-details" style="margin-top: 20px;">
                        <h4><i class="fas fa-sticky-note"></i> Notes</h4>
                        <p style="color: var(--gray-light); line-height: 1.6;">{{ $payment->notes }}</p>
                    </div>
                @endif

                <!-- Receipt Image if available -->
                @if ($payment->receipt_image)
                    <div class="receipt-image">
                        <h4 style="color: white; margin-bottom: 10px;"><i class="fas fa-image"></i> Receipt Image</h4>
                        <img src="{{ asset($payment->receipt_image) }}" alt="Receipt Image">
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('payments.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Payments
                    </a>
                    <a href="{{ route('payments.receipt.view', $payment->id) }}" target="_blank" class="btn-secondary">
                        <i class="fas fa-eye"></i>
                        View Receipt
                    </a>
                    <a href="{{ route('payments.receipt.download', $payment->id) }}" class="btn-primary">
                        <i class="fas fa-download"></i>
                        Download Receipt
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
