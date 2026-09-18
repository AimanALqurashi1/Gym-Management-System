@extends('layouts.home')

@section('title', 'Add Member to Schedule')

@section('css')
    <style>
        /* Add Member Container - Light Theme */
        .add-member-container {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2.2rem;
            color: var(--dark);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header h1 i {
            color: var(--primary);
        }

        /* Schedule Summary - Light Theme */
        .schedule-summary {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .summary-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .summary-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .summary-content .label {
            color: var(--gray);
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .summary-content .value {
            color: var(--dark);
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Members List Section - Light Theme */
        .members-list-section {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .members-list-section h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .members-list-section h3 i {
            color: var(--primary);
        }

        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        /* Member Card - Light Theme */
        .member-card {
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .member-card:hover {
            border-color: var(--primary);
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .member-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .member-info {
            flex: 1;
        }

        .member-info h4 {
            color: var(--dark);
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .member-info p {
            color: var(--gray);
            font-size: 0.85rem;
            margin: 2px 0;
        }

        .enrolled-date {
            font-size: 0.75rem;
            color: var(--primary);
            background: rgba(255, 85, 0, 0.1);
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
        }

        /* Payment Status Badge */
        .payment-status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .payment-status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .payment-status-partial {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .payment-status-pending {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
        }

        .payment-status-overdue {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        /* Member overdue row */
        .member-card.member-overdue {
            border-left: 3px solid var(--danger);
            background: rgba(220, 53, 69, 0.03);
        }

        /* Form Card - Light Theme */
        .form-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

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
            box-shadow: 0 0 0 4px var(--primary-light);
            background: white;
        }

        select.form-control {
            cursor: pointer;
        }

        /* Payment Summary Card - Light Theme */
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

        /* Plan Options - Light Theme */
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

        /* Buttons - Light Theme */
        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
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

        /* Spots Indicator - Light Theme */
        .spots-indicator {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .spots-available {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .spots-full {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        /* Payment Terms Notice */
        .payment-terms-notice {
            background: rgba(40, 167, 69, 0.05);
            border-left: 4px solid var(--success);
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .payment-terms-notice i {
            color: var(--success);
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .schedule-summary {
                grid-template-columns: 1fr;
            }

            .payment-details-grid {
                grid-template-columns: 1fr;
            }

            .plan-options {
                flex-direction: column;
            }

            .members-grid {
                grid-template-columns: 1fr;
            }

            .member-card {
                flex-direction: column;
                text-align: center;
            }

            .member-avatar {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 576px) {
            .add-member-container {
                padding: 20px;
            }

            .form-card {
                padding: 20px;
            }

            .members-list-section {
                padding: 15px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        /* Animation for cards */
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

        .member-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Hover effects */
        .member-card:hover .btn-payment {
            background: var(--primary);
            color: white;
        }

        /* Button Payment */
        .btn-payment {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            margin-top: 8px;
        }

        .btn-payment:hover {
            background: var(--primary);
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="add-member-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-user-plus"></i>
                Add Member to Schedule
            </h1>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
                <a href="{{ route('Schedule.MemberSchedule', $schedule->course_id) }}">Course Schedule</a> /
                <span>Add Member</span>
            </div>
        </div>

        <!-- Schedule Summary -->
        <div class="schedule-summary">
            <div class="summary-item">
                <div class="summary-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="summary-content">
                    <div class="label">Trainer</div>
                    <div class="value">{{ $schedule->trainer->name ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="summary-content">
                    <div class="label">Course</div>
                    <div class="value">{{ $schedule->course->name ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-content">
                    <div class="label">Time</div>
                    <div class="value">
                        {{ ucfirst($schedule->day_of_week) }} •
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} -
                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                    </div>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="summary-content">
                    <div class="label">Available Spots</div>
                    <div class="value">
                        {{ $availableSpots }} / {{ $totalSpots }}
                        <span class="spots-indicator {{ $availableSpots > 0 ? 'spots-available' : 'spots-full' }}">
                            <i class="fas {{ $availableSpots > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $availableSpots > 0 ? 'Available' : 'Full' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Current Members List -->
        <div class="members-list-section">
            <h3>
                <i class="fas fa-users"></i>
                Current Members in this Schedule ({{ $currentMembers }})
            </h3>

            @if ($schedule->member->count() > 0)
                <div class="members-grid">
                    @foreach ($schedule->member as $member)
                        <div class="member-card">
                            <div class="member-avatar">
                                @if (!empty($member->photo))
                                    <img src="{{ asset('admin/uploads/' . $member->photo) }}" alt="{{ $member->name }}">
                                @else
                                    <i class="fas fa-user-circle"></i>
                                @endif
                            </div>
                            <div class="member-info">
                                <h4>{{ $member->name }}</h4>
                                <p><i class="fas fa-id-card"></i> {{ $member->code ?? 'N/A' }}</p>
                                <p><i class="fas fa-calendar-alt"></i>
                                    Enrolled: {{ \Carbon\Carbon::parse($member->pivot->enrolled_date)->format('M d, Y') }}
                                </p>
                                @if ($member->pivot->expiry_date)
                                    <span class="enrolled-date">
                                        <i class="fas fa-hourglass-end"></i>
                                        Expires: {{ \Carbon\Carbon::parse($member->pivot->expiry_date)->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: var(--gray-light); text-align: center; padding: 30px;">
                    <i class="fas fa-info-circle"></i> No members in this schedule yet.
                </p>
            @endif
        </div>

        <!-- Add Member Form -->
        <div class="form-card">
            <h3 style="color: white; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user-plus" style="color: var(--primary);"></i>
                Add New Member
            </h3>

            <form action="{{ route('classInstance.addMemberToExistingSchedule', $schedule->id) }}" method="POST">
                @csrf

                <div class="form-row">
                    <!-- Member Selection -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user"></i>
                            Select Member <span class="required" style="color: var(--danger);">*</span>
                        </label>
                        <select name="member_id" class="form-control" required>
                            <option value="">-- Choose a member --</option>
                            @foreach ($availableMembers as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->code ?? 'No Code' }})
                                </option>
                            @endforeach
                        </select>
                        @if ($availableMembers->isEmpty())
                            <small style="color: var(--warning); display: block; margin-top: 5px;">
                                <i class="fas fa-exclamation-triangle"></i>
                                No available members to add. All members are already in this schedule.
                            </small>
                        @endif
                    </div>

                    <!-- Plan Selection -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-tag"></i>
                            Select Plan <span class="required" style="color: var(--danger);">*</span>
                        </label>
                        <select name="plan_id" class="form-control" required>
                            <option value="">-- Choose a plan --</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->Type }} ({{ $plan->duration_in_days }} days)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Enrolled Date -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-plus"></i>
                            Enrolled Date <span class="required" style="color: var(--danger);">*</span>
                        </label>
                        <input type="date" name="enrolled_date" class="form-control"
                            value="{{ old('enrolled_date', now()->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Expiry Date -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-times"></i>
                            Expiry Date
                        </label>
                        <input type="date" name="expiry_date" class="form-control"
                            value="{{ old('expiry_date', $schedule->recurrence_end_date ? \Carbon\Carbon::parse($schedule->recurrence_end_date)->format('Y-m-d') : '') }}">
                        <small style="color: var(--gray-light); display: block; margin-top: 5px;">
                            <i class="fas fa-info-circle"></i>
                            Leave empty to use schedule's end date
                        </small>
                    </div>
                </div>

                <!-- Schedule Info Notice -->
                <div
                    style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid var(--warning); padding: 15px; margin: 20px 0; border-radius: 5px;">
                    <i class="fas fa-clock" style="color: var(--warning); margin-right: 10px;"></i>
                    <span style="color: var(--gray-light);">
                        This member will be added to all <strong>future class instances</strong> starting from the enrolled
                        date.
                        @if ($schedule->recurrence_end_date)
                            The schedule runs until
                            {{ \Carbon\Carbon::parse($schedule->recurrence_end_date)->format('M d, Y') }}.
                        @endif
                    </span>
                </div>

                <!-- Form Actions -->
                <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px;">
                    <a href="{{ route('Schedule.MemberSchedule', $schedule->course_id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary"
                        {{ $availableMembers->isEmpty() || $availableSpots <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-user-plus"></i>
                        Add Member to Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Client-side validation
            $('form').on('submit', function(e) {
                const enrolledDate = new Date($('input[name="enrolled_date"]').val());
                const expiryDate = $('input[name="expiry_date"]').val() ? new Date($(
                    'input[name="expiry_date"]').val()) : null;

                if (expiryDate && expiryDate < enrolledDate) {
                    e.preventDefault();
                    alert('Expiry date must be after enrolled date');
                }
            });

            // Show warning if trying to add member when no spots available
            @if ($availableSpots <= 0)
                $('form').on('submit', function(e) {
                    e.preventDefault();
                    alert('This schedule is full. No available spots.');
                });
            @endif
        });
    </script>
@endsection
