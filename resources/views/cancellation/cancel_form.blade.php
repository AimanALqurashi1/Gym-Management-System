@extends('layouts.home')

@section('title', 'Cancel Enrollment')

@section('css')
    <style>
        /* Cancel Container - Light Theme */
        .cancel-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Cancel Card - Light Theme */
        .cancel-card {
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

        /* Warning Box - Light Theme */
        .warning-box {
            background: rgba(220, 53, 69, 0.05);
            border-left: 4px solid var(--danger);
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
        }

        .warning-box i {
            color: var(--danger);
            margin-right: 10px;
        }

        .warning-box strong {
            color: var(--danger);
        }

        .warning-box p {
            color: var(--dark);
            margin-top: 8px;
        }

        /* Info Box - Light Theme */
        .info-box {
            background: #fafafa;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }

        .info-box h4 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box h4 i {
            color: var(--primary);
        }

        /* Refund Box - Light Theme */
        .refund-box {
            background: rgba(40, 167, 69, 0.05);
            border-left: 4px solid var(--success);
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
        }

        .refund-box i {
            color: var(--success);
            margin-right: 10px;
        }

        .refund-box strong {
            color: var(--success);
        }

        .refund-box p {
            color: var(--dark);
            margin-top: 8px;
        }

        /* No Refund Box - Light Theme */
        .no-refund-box {
            background: rgba(220, 53, 69, 0.03);
            border-left: 4px solid var(--danger);
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
        }

        .no-refund-box i {
            color: var(--danger);
            margin-right: 10px;
        }

        .no-refund-box strong {
            color: var(--danger);
        }

        .no-refund-box p {
            color: var(--dark);
            margin-top: 8px;
        }

        /* Form Group - Light Theme */
        .form-group {
            margin: 20px;
        }

        .form-group label {
            display: block;
            color: var(--dark);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Info Row - Light Theme */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--gray);
        }

        .info-value {
            color: var(--dark);
            font-weight: 500;
        }

        .info-value strong {
            color: var(--primary);
        }

        /* Refund Amount - Light Theme */
        .refund-amount {
            font-size: 1.5rem;
            color: var(--success);
            font-weight: 700;
        }

        /* Buttons - Light Theme */
        .btn-danger {
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

        .btn-danger:hover {
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

        /* ADDED: Refund Calculator Section */
        .refund-calculator {
            background: #fafafa;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
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

        .refund-days {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .refund-days .label {
            color: var(--gray);
        }

        .refund-days .value {
            color: var(--dark);
            font-weight: 600;
        }

        .refund-days .value.warning {
            color: var(--warning);
        }

        .refund-days .value.danger {
            color: var(--danger);
        }

        .refund-days .value.success {
            color: var(--success);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cancel-container {
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

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn-secondary,
            .action-buttons .btn-danger {
                width: 100%;
                justify-content: center;
            }

            .warning-box,
            .info-box,
            .refund-box,
            .no-refund-box,
            .form-group,
            .refund-calculator {
                margin: 15px;
            }
        }

        @media (max-width: 576px) {
            .cancel-container {
                padding: 15px;
            }

            .card-header {
                padding: 15px;
            }

            .card-header h2 {
                font-size: 1.1rem;
            }

            .warning-box,
            .info-box,
            .refund-box,
            .no-refund-box,
            .form-group,
            .refund-calculator {
                margin: 10px;
                padding: 12px;
            }

            .refund-amount {
                font-size: 1.2rem;
            }

            .btn-danger,
            .btn-secondary {
                padding: 10px 16px;
                font-size: 0.9rem;
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

        .cancel-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Loading state for button */
        .btn-danger.loading {
            opacity: 0.7;
            cursor: wait;
        }

        .btn-danger.loading i {
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

        /* Alert styles inside cancellation */
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.08);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.08);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.08);
            border: 1px solid var(--warning);
            color: var(--warning);
        }
    </style>
@endsection

@section('content')
    <div class="cancel-container">
        <div class="cancel-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-ban"></i>
                    Cancel Enrollment
                </h2>
            </div>

            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Warning:</strong> This action cannot be undone. The member will be removed from all future classes.
            </div>

            <!-- Enrollment Details -->
            <div class="info-box">
                <h4 style="color: white; margin-bottom: 15px;">Enrollment Details</h4>
                <div class="info-row">
                    <span class="info-label">Member:</span>
                    <span class="info-value">{{ $enrollment->member->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Course:</span>
                    <span class="info-value">{{ $enrollment->schedule->course->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Trainer:</span>
                    <span class="info-value">{{ $enrollment->schedule->trainer->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Enrolled Date:</span>
                    <span
                        class="info-value">{{ \Carbon\Carbon::parse($enrollment->enrolled_date)->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Expiry Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($enrollment->expiry_date)->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Amount:</span>
                    <span class="info-value">${{ number_format($enrollment->total_amount, 2) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Amount Paid:</span>
                    <span class="info-value">${{ number_format($enrollment->amount_paid, 2) }}</span>
                </div>
            </div>

            <!-- Refund Information -->
            @if ($refundInfo['eligible'])
                <div class="refund-box">
                    <i class="fas fa-money-bill-wave"></i>
                    <strong>Refund Eligible!</strong>
                    <p style="margin-top: 10px;">{{ $refundInfo['message'] }}</p>
                    <div style="margin-top: 10px;">
                        <span>Refund Amount: </span>
                        <span class="refund-amount">${{ number_format($refundInfo['amount'], 2) }}</span>
                        <span> ({{ $refundInfo['percentage'] }}%)</span>
                    </div>
                    <small>Days since enrollment: {{ $refundInfo['days_since_enrollment'] }} /
                        {{ round($refundInfo['half_period_days']) }} days (half period)</small>
                </div>
            @else
                <div class="no-refund-box">
                    <i class="fas fa-times-circle"></i>
                    <strong>No Refund Available</strong>
                    <p style="margin-top: 10px;">{{ $refundInfo['message'] }}</p>
                    <small>Days since enrollment: {{ $refundInfo['days_since_enrollment'] }} /
                        {{ round($refundInfo['half_period_days']) }} days (half period)</small>
                </div>
            @endif

            <!-- Cancellation Form -->
            <form action="{{ route('cancellation.process', $enrollment->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label><i class="fas fa-comment"></i> Cancellation Reason *</label>
                    <textarea name="cancellation_reason" class="form-control" rows="4"
                        placeholder="Please provide the reason for cancellation..." required></textarea>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Additional Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes..."></textarea>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('cancellation.manage') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-ban"></i> Confirm Cancellation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
