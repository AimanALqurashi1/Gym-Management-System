@extends('layouts.home')

@section('title', 'Make Payment')
@section('css')
    <style>
        /* Form Container - Light Theme */
        .form-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Form Card - Light Theme */
        .form-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-card h2 {
            color: var(--dark);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-card h2 i {
            color: var(--primary);
        }

        /* Member Info - Light Theme */
        .member-info {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
        }

        .member-info h3 {
            color: var(--dark);
            margin-bottom: 5px;
        }

        .member-info p {
            color: var(--gray);
            margin: 0;
        }

        /* Form Groups - Light Theme */
        .form-group {
            margin-bottom: 20px;
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

        .form-control[readonly] {
            background: rgba(255, 85, 0, 0.05);
            border-color: var(--primary);
            cursor: not-allowed;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ff5500' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
        }

        select.form-control option {
            background: white;
            color: var(--dark);
        }

        /* Info Box - Light Theme */
        .info-box {
            background: var(--primary-light);
            border-left: 4px solid var(--primary);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-box p {
            color: var(--dark);
            margin: 5px 0;
        }

        .info-box .label {
            color: var(--gray);
            font-size: 0.85rem;
        }

        .info-box .value {
            font-weight: 600;
            color: var(--dark);
        }

        /* ADDED: Payment Summary Card */
        .payment-summary-card {
            background: #fafafa;
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid var(--border-color);
        }

        .payment-summary-card h4 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-summary-card h4 i {
            color: var(--primary);
        }

        .payment-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .payment-detail {
            background: white;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .payment-detail .label {
            color: var(--gray);
            font-size: 0.75rem;
            margin-bottom: 3px;
        }

        .payment-detail .value {
            color: var(--dark);
            font-size: 1rem;
            font-weight: 600;
        }

        .payment-warning-box {
            background: rgba(255, 193, 7, 0.08);
            border-left: 4px solid var(--warning);
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .payment-warning-box i {
            color: var(--warning);
            margin-right: 8px;
        }

        .payment-warning-box strong {
            color: var(--warning);
        }

        /* Buttons - Light Theme */
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Image Preview - Light Theme */
        .image-preview {
            width: 150px;
            height: 150px;
            background: #f5f5f5;
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
            transition: var(--transition);
        }

        .image-preview:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-upload {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            display: inline-block;
            transition: var(--transition);
        }

        .btn-upload:hover {
            background: var(--primary);
            color: white;
        }

        /* ADDED: Plan Selection Styles */
        .plan-selection {
            margin-bottom: 25px;
        }

        .plan-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .plan-option {
            flex: 1;
            min-width: 150px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .plan-option:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .plan-option.selected {
            border-color: var(--primary);
            background: rgba(255, 85, 0, 0.1);
        }

        .plan-option .plan-name {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .plan-option .plan-price {
            color: var(--primary);
            font-size: 1.2rem;
            font-weight: 700;
        }

        .plan-option .plan-duration {
            color: var(--gray);
            font-size: 0.75rem;
        }

        /* Alerts - Light Theme */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
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

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .form-actions .btn-primary,
        .form-actions .btn-secondary {
            width: auto;
            flex: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-card {
                padding: 20px;
            }

            .payment-details-grid {
                grid-template-columns: 1fr;
            }

            .plan-options {
                flex-direction: column;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn-primary,
            .form-actions .btn-secondary {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 15px;
            }

            .form-card {
                padding: 15px;
            }

            .form-card h2 {
                font-size: 1.3rem;
            }

            .member-info h3 {
                font-size: 1.1rem;
            }

            .image-preview {
                width: 120px;
                height: 120px;
                margin: 0 auto 15px;
            }

            .btn-upload {
                display: block;
                text-align: center;
                margin: 0 auto;
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

        .form-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Loading state for button */
        .btn-primary.loading {
            opacity: 0.7;
            cursor: wait;
        }

        .btn-primary.loading i {
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

        /* Checkbox group styling */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-group label {
            color: var(--dark);
            cursor: pointer;
            margin: 0;
        }

        /* Radio group styling */
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .radio-option input[type="radio"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .radio-option span {
            color: var(--dark);
        }
    </style>
@endsection
@section('content')
    <div class="container" style="padding: 30px; max-width: 600px; margin: 0 auto;">
        <div class="card" style="background: var(--secondary-light); border-radius: 15px; overflow: hidden;">
            <div class="card-header"
                style="background: linear-gradient(135deg, var(--primary-light), rgba(255,85,0,0.1)); padding: 20px; border-bottom: 2px solid var(--primary);">
                <h2 style="color: black; margin: 0;">
                    <i class="fas fa-dollar-sign"></i> Make a Payment
                </h2>
            </div>
            <div class="card-body" style="padding: 30px;">

                <!-- Course Details -->
                <div style="background: var(--dark-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h4 style="color: black; margin-bottom: 10px;">{{ $enrollment->schedule->course->name ?? 'Course' }}
                    </h4>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: var(--gray-light);">Member:</span>
                        <span style="color: black;">{{ $member->name }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: var(--gray-light);">Trainer:</span>
                        <span style="color: black;">{{ $enrollment->schedule->trainer->name ?? 'N/A' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: var(--gray-light);">Schedule:</span>
                        <span style="color: black;">{{ ucfirst($enrollment->schedule->day_of_week ?? '') }} at
                            {{ \Carbon\Carbon::parse($enrollment->schedule->start_time ?? '')->format('g:i A') }}</span>
                    </div>

                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--border-color);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: var(--gray-light);">Total Amount:</span>
                            <strong
                                style="color: var(--primary);">${{ number_format($enrollment->total_amount, 2) }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: var(--gray-light);">Already Paid:</span>
                            <strong
                                style="color: var(--success);">${{ number_format($enrollment->amount_paid, 2) }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--gray-light);">Remaining Balance:</span>
                            <strong style="color: var(--warning);">${{ number_format($remaining, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="{{ route('payments.storeForCourse', $enrollment->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div style="margin-bottom: 20px;">
                        <label style="color: black; display: block; margin-bottom: 8px;">Amount to Pay *</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required
                            max="{{ round($remaining, 2) }}" placeholder="Enter amount"
                            style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: black;">
                        <small style="color: var(--gray-light);">Maximum: ${{ number_format($remaining, 2) }}</small>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="color: black; display: block; margin-bottom: 8px;">Payment Date *</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required
                            style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: black;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="color: black; display: block; margin-bottom: 8px;">Receipt Image (Optional)</label>
                        <input type="file" name="receipt_image" accept="image/*"
                            style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: black;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="color: black; display: block; margin-bottom: 8px;">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"
                            style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: black;"></textarea>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <a href="{{ route('payments.payment_list') }}"
                            style="background: transparent; color: black; border: 2px solid var(--border-color); padding: 12px 24px; border-radius: 50px; text-decoration: none;">
                            Cancel
                        </a>
                        <button type="submit"
                            style="background: var(--primary); color: black; border: none; padding: 12px 24px; border-radius: 50px; cursor: pointer; flex: 1;">
                            <i class="fas fa-save"></i> Make Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
