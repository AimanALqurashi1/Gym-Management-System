@extends('layouts.home')

@section('title', 'Record Payment')

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

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
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

        /* Form action buttons container */
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
    </style>
@endsection
@section('content')
    <div style="padding: 30px; max-width: 600px; margin: 0 auto;">
        <div style="background: var(--secondary-light); border-radius: 15px; padding: 30px;">
            <h2 style="color: white; margin-bottom: 25px;">Record Payment - Cash Only</h2>

            <div style="background: var(--dark-light); padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <h4 style="color: white;">{{ $member->name }}</h4>
                <p style="color: var(--gray-light);">Member Code: {{ $member->code ?? 'N/A' }}</p>
            </div>

            @if ($errors->any())
                <div
                    style="background: rgba(220,53,69,0.15); padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #dc3545;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/payments') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="member_id" value="{{ $member->id }}">

                <div style="margin-bottom: 20px;">
                    <label style="color: white; display: block; margin-bottom: 8px;">Amount Paid *</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required
                        style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: white;"
                        placeholder="Enter amount">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: white; display: block; margin-bottom: 8px;">Payment Date *</label>
                    <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required
                        style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: white;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: white; display: block; margin-bottom: 8px;">Receipt Image (Optional)</label>
                    <input type="file" name="receipt_image" accept="image/*"
                        style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: white;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: white; display: block; margin-bottom: 8px;">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"
                        style="width: 100%; padding: 12px; background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 8px; color: white;"></textarea>
                </div>

                <div style="display: flex; gap: 15px;">
                    <a href="{{ url('/payments') }}"
                        style="background: transparent; color: white; border: 2px solid var(--border-color); padding: 12px 24px; border-radius: 50px; text-decoration: none;">
                        Cancel
                    </a>
                    <button type="submit"
                        style="background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: 50px; cursor: pointer; flex: 1;">
                        Record Payment & Generate Receipt
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
