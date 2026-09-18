@extends('layouts.home')

@section('title', 'Select Member for Payment')

@section('css')
    <style>
        /* Select Container - Light Theme */
        .select-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Select Card - Light Theme */
        .select-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .select-card h2 {
            color: var(--dark);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .select-card h2 i {
            color: var(--primary);
        }

        /* Member List - Light Theme */
        .member-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .member-item {
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }

        .member-item:hover {
            border-color: var(--primary);
            transform: translateX(5px);
            background: var(--primary-light);
            box-shadow: 0 2px 8px rgba(255, 85, 0, 0.1);
        }

        .member-item:last-child {
            margin-bottom: 0;
        }

        /* Member Info - Light Theme */
        .member-info h3 {
            color: var(--dark);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .member-info p {
            color: var(--gray);
            margin: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .member-info p i {
            color: var(--primary);
            width: 16px;
        }

        /* ADDED: Member Status Badge */
        .member-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .member-status.active {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .member-status.inactive {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
        }

        /* ADDED: Payment Status Badge */
        .payment-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .payment-status.paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .payment-status.partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .payment-status.pending {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
        }

        .payment-status.overdue {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        /* Button Select - Light Theme */
        .btn-select {
            background: var(--primary);
            color: rgb(238, 138, 138);
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-select:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-select i {
            font-size: 0.9rem;
        }

        /* No Data - Light Theme */
        .no-data {
            text-align: center;
            padding: 60px 40px;
            color: var(--gray);
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
            color: var(--primary);
        }

        .no-data p {
            margin: 0;
            font-size: 1rem;
        }

        /* ADDED: Search Box */
        .search-box {
            margin-bottom: 20px;
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            color: var(--dark);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .search-box input::placeholder {
            color: var(--gray);
        }

        /* ADDED: Loading State */
        .loading-members {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }

        .loading-members i {
            font-size: 2rem;
            color: var(--primary);
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
            display: inline-block;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Empty State with Action */
        .empty-state-action {
            text-align: center;
            padding: 50px;
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .empty-state-action i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state-action h3 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state-action p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        .btn-add-member {
            background: var(--primary);
            color: rgb(77, 32, 32);
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .btn-add-member:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .select-container {
                padding: 20px;
            }

            .select-card {
                padding: 20px;
            }

            .member-item {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }

            .member-info {
                text-align: center;
            }

            .member-info p {
                justify-content: center;
            }

            .btn-select {
                width: 100%;
                justify-content: center;
            }

            .empty-state-action {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .select-container {
                padding: 15px;
            }

            .select-card {
                padding: 15px;
            }

            .select-card h2 {
                font-size: 1.3rem;
            }

            .member-item {
                padding: 12px 15px;
            }

            .member-info h3 {
                font-size: 1rem;
            }

            .no-data {
                padding: 40px 20px;
            }
        }

        /* Animation for member items */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .member-item {
            animation: fadeInLeft 0.3s ease forwards;
        }

        .member-item:nth-child(1) {
            animation-delay: 0s;
        }

        .member-item:nth-child(2) {
            animation-delay: 0.05s;
        }

        .member-item:nth-child(3) {
            animation-delay: 0.1s;
        }

        .member-item:nth-child(4) {
            animation-delay: 0.15s;
        }

        .member-item:nth-child(5) {
            animation-delay: 0.2s;
        }

        .member-item:nth-child(6) {
            animation-delay: 0.25s;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding: 30px;">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card" style="background: var(--secondary-light); border-radius: 15px; overflow: hidden;">
                    <div class="card-header"
                        style="background: linear-gradient(135deg, var(--primary-light), rgba(255,85,0,0.1)); padding: 20px; border-bottom: 2px solid var(--primary);">
                        <h2 style="color: black; margin: 0;">
                            <i class="fas fa-credit-card"></i> Select Member for Payment
                        </h2>
                    </div>
                    <div class="card-body" style="padding: 30px;">
                        @if ($members->count() > 0)
                            <div class="members-list">
                                @foreach ($members as $member)
                                    <div
                                        style="background: var(--dark-light); padding: 15px; margin-bottom: 15px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <h4 style="color: black; margin-bottom: 5px;">{{ $member->name }}</h4>
                                            <p style="color: var(--gray-light); margin: 0;">Code:
                                                {{ $member->code ?? 'N/A' }}</p>
                                        </div>
                                        <a href="{{ route('payments.payment_list', ['member_id' => $member->id]) }}"
                                            class="btn btn-primary"
                                            style="background: var(--primary); color: black; padding: 10px 20px; border-radius: 50px; text-decoration: none;">
                                            <i class="fas fa-dollar-sign"></i> Record Payment
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 40px;">
                                <i class="fas fa-users" style="font-size: 3rem; color: var(--gray-light);"></i>
                                <p style="color: var(--gray-light); margin-top: 15px;">No active members found with pending
                                    payments.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Go to Dashboard</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
