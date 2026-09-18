@extends('layouts.home')

@section('title', 'Refund Preview')

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
    <div class="preview-container">
        <div class="preview-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-calculator"></i>
                    Refund Calculator
                </h2>
            </div>

            <div class="info-section">
                <div class="refund-calculator">
                    <h4 style="color: white; margin-bottom: 15px;">Enrollment Details</h4>
                    <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--gray-light);">Member:</span>
                        <span style="color: white;">{{ $enrollment->member->name }}</span>
                    </div>
                    <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--gray-light);">Course:</span>
                        <span style="color: white;">{{ $enrollment->schedule->course->name }}</span>
                    </div>
                    <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--gray-light);">Enrolled Date:</span>
                        <span
                            style="color: white;">{{ \Carbon\Carbon::parse($enrollment->enrolled_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--gray-light);">Days Active:</span>
                        <span
                            style="color: {{ $refundInfo['days_since_enrollment'] <= 2 ? 'var(--success)' : ($refundInfo['days_since_enrollment'] <= $refundInfo['half_period_days'] ? 'var(--warning)' : 'var(--danger)') }}">
                            {{ $refundInfo['days_since_enrollment'] }} days
                        </span>
                    </div>
                    <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--gray-light);">Half Period:</span>
                        <span style="color: white;">{{ round($refundInfo['half_period_days']) }} days</span>
                    </div>
                    <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: var(--gray-light);">Total Paid:</span>
                        <span style="color: white;">${{ number_format($enrollment->amount_paid, 2) }}</span>
                    </div>
                </div>

                <div class="refund-calculator">
                    <h4 style="color: white; margin-bottom: 15px;">Refund Calculation</h4>
                    <div class="refund-amount">
                        ${{ number_format($refundInfo['amount'], 2) }}
                    </div>
                    <div style="text-align: center;">
                        <span class="refund-badge"
                            style="display: inline-block; padding: 5px 15px; border-radius: 50px; background: rgba(255, 85, 0, 0.15); color: var(--primary);">
                            {{ $refundInfo['percentage'] }}% Refund
                        </span>
                    </div>
                </div>

                <div class="rule-box">
                    <i class="fas fa-info-circle"></i>
                    <strong>Refund Policy:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        <li>Within 2 days of enrollment → <strong>100% refund</strong></li>
                        <li>Within first half of period → <strong>50% refund</strong></li>
                        <li>After half period → <strong>No refund</strong></li>
                    </ul>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('cancellation.manage') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('cancellation.form', $enrollment->id) }}" class="btn-cancel-action">
                        <i class="fas fa-ban"></i> Proceed to Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
