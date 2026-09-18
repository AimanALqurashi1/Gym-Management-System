@extends('layouts.home')

@section('title', 'Create Schedule')
@section('css')
    <style>
        /* Schedule Create Page Styles */
        /* Schedule Container - Light Theme */
        .schedule-container {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Page Header - Light Theme */
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
            font-size: 2rem;
        }

        .page-header .breadcrumb {
            color: var(--gray);
            margin-top: 10px;
        }

        .page-header .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .page-header .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Selected Time Slot Banner - Light Theme */
        .time-slot-banner {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 20px 25px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            animation: pulse 2s infinite;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 85, 0, 0.3);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 85, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 85, 0, 0);
            }
        }

        .time-slot-banner .time-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .time-slot-banner .time-icon i {
            font-size: 2rem;
            color: white;
        }

        .time-slot-banner .time-info {
            flex: 1;
        }

        .time-slot-banner .time-info .label {
            color: var(--gray);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .time-slot-banner .time-info .value {
            color: var(--dark);
            font-size: 1.4rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
        }

        .time-slot-banner .time-info .sub-value {
            color: var(--primary);
            font-size: 1rem;
            margin-top: 5px;
        }

        /* Info Cards Section - Light Theme */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .info-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .info-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .info-card .card-icon {
            width: 70px;
            height: 70px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--border-primary);
        }

        .info-card .card-icon i {
            font-size: 2rem;
            color: var(--primary);
        }

        .info-card .card-content {
            flex: 1;
        }

        .info-card .card-content .label {
            color: var(--gray);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .info-card .card-content .value {
            color: var(--dark);
            font-size: 1.2rem;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
        }

        .info-card .card-content .sub-value {
            color: var(--gray);
            font-size: 0.9rem;
            margin-top: 3px;
        }

        /* Price styling */
        .info-card .card-content .price {
            color: var(--primary);
            font-size: 1.3rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card .card-content .price i {
            font-size: 1rem;
            color: var(--primary);
        }

        /* Form Card - Light Theme */
        .form-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-card .form-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-card .form-header h2 {
            color: var(--dark);
            font-size: 1.8rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-card .form-header h2 i {
            color: var(--primary);
        }

        .form-card .form-header p {
            color: var(--gray);
            margin-top: 10px;
        }

        /* Payment Info Card - Light Theme */
        .payment-info-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 25px;
        }

        .payment-info-card h4 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-info-card h4 i {
            color: var(--primary);
        }

        .payment-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .payment-detail-item {
            background: #fafafa;
            padding: 12px;
            border-radius: 10px;
        }

        .payment-detail-item .label {
            color: var(--gray);
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        .payment-detail-item .value {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .payment-warning {
            background: rgba(255, 193, 7, 0.08);
            border-left: 3px solid var(--warning);
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .payment-warning i {
            color: var(--warning);
            margin-right: 8px;
        }

        .payment-warning strong {
            color: var(--warning);
        }

        /* Plan Card Styles - Light Theme */
        .plan-card {
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .plan-card:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .plan-card.selected {
            border-color: var(--primary);
            background: rgba(255, 85, 0, 0.1);
        }

        .plan-card .plan-name {
            font-weight: 600;
            color: var(--dark);
        }

        .plan-card .plan-price {
            color: var(--primary);
            font-weight: 700;
        }

        .plan-card .plan-duration {
            color: var(--gray);
            font-size: 0.8rem;
        }

        /* Form Layout */
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-group label i {
            color: var(--primary);
            width: 20px;
        }

        .form-group label .required {
            color: var(--danger);
            margin-left: 5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            font-family: 'Open Sans', sans-serif;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control[readonly] {
            background: rgba(255, 85, 0, 0.08);
            border-color: var(--primary);
            cursor: not-allowed;
            opacity: 0.9;
        }

        .form-control:hover {
            border-color: var(--border-primary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
            background: white;
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

        /* Toggle Switch - Light Theme */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e9ecef;
            transition: var(--transition);
            border-radius: 34px;
            border: 2px solid var(--border-color);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: var(--transition);
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: var(--primary-light);
            border-color: var(--primary);
        }

        input:checked+.toggle-slider:before {
            transform: translateX(26px);
            background-color: var(--primary);
        }

        .toggle-label {
            margin-left: 70px;
            display: block;
            color: var(--dark);
            font-size: 0.95rem;
        }

        /* Checkbox Styles - Light Theme */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-item span {
            color: var(--dark);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
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
            text-transform: uppercase;
            letter-spacing: 1px;
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
            transform: translateY(-3px);
        }

        /* Notification Styles - Light Theme */
        .schedule-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideIn 0.3s ease;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            overflow: hidden;
        }

        .schedule-notification.alert-success {
            border-left: 4px solid var(--success);
        }

        .schedule-notification.alert-success i {
            color: var(--success);
        }

        .schedule-notification.alert-danger {
            border-left: 4px solid var(--danger);
        }

        .schedule-notification.alert-danger i {
            color: var(--danger);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .info-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .payment-details {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .schedule-container {
                padding: 20px;
            }

            .info-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .time-slot-banner {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .payment-details {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .info-card {
                flex-direction: column;
                text-align: center;
            }

            .info-card .card-icon {
                margin: 0 auto;
            }
        }
    </style>
@endsection

@section('content')
    <div class="schedule-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-calendar-plus"></i>
                Create New Schedule
            </h1>
            <div class="breadcrumb">
                <a href="#">Dashboard</a> /
                <a href="#">Schedules</a> /
                <span>Create Schedule</span>
            </div>
        </div>

        <!-- Selected Time Slot Banner -->
        <div class="time-slot-banner">
            <div class="time-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="time-info">
                <div class="label">Selected Time Slot</div>
                <div class="value">
                    {{ ucfirst($selectedDay ?? '') }} • {{ $startTime ?? '' }} - {{ $endTime ?? '' }}
                </div>
                <div class="sub-value">
                    <i class="fas fa-calendar-alt"></i> Date: {{ $selectedDate ?? '' }}
                </div>
            </div>
            <div style="margin-left: auto;">
                <span class="status-badge status-active">
                    <i class="fas fa-check-circle"></i> Creating new schedule
                </span>
            </div>
        </div>

        <!-- Info Cards Section -->
        <div class="info-cards">
            <!-- Member Card -->
            <div class="info-card">
                <div class="card-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-content">
                    <div class="label">Member</div>
                    <div class="value">{{ $member->name ?? 'N/A' }}</div>
                    <div class="sub-value">
                        <i class="fas fa-envelope" style="font-size: 0.8rem; margin-right: 5px;"></i>
                        {{ $member->email ?? 'No email' }}
                    </div>
                </div>
            </div>

            <!-- Trainer Card -->
            <div class="info-card">
                <div class="card-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-content">
                    <div class="label">Trainer</div>
                    <div class="value">{{ $trainer->name ?? 'N/A' }}</div>
                    <div class="sub-value">
                        <i class="fas fa-phone" style="font-size: 0.8rem; margin-right: 5px;"></i>
                        {{ $trainer->phone ?? 'No phone' }}
                    </div>
                </div>
            </div>

            <!-- Class Card with Price -->
            <div class="info-card">
                <div class="card-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="card-content">
                    <div class="label">Class</div>
                    <div class="value">{{ $course->name ?? 'N/A' }}</div>
                    <div class="sub-value">
                        <i class="fas fa-tag" style="font-size: 0.8rem; margin-right: 5px;"></i>
                        {{ $class->category ?? 'No category' }}
                    </div>
                    @if (isset($course->price) && $course->price)
                        <div class="price">
                            <i class="fas fa-dollar-sign"></i>
                            {{ number_format($course->price, 2) }}
                        </div>
                    @elseif(isset($course->price) && $course->price === 0)
                        <div class="price">
                            <i class="fas fa-gift"></i>
                            Free
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-header">
                <h2>
                    <i class="fas fa-clock"></i>
                    Schedule Details
                </h2>
                <p>Complete the form below to create your schedule</p>
            </div>

            <form id="schedule-form" action="{{ route('classInstance.store') }}" method="POST">
                @csrf

                <!-- Hidden inputs -->
                <input type="hidden" name="member_id" value="{{ $member->id ?? '' }}">
                <input type="hidden" name="trainer_id" value="{{ $trainer->id ?? '' }}">
                <input type="hidden" name="course_id" value="{{ $course->id ?? '' }}">

                <!-- Pre-filled time slot data -->
                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-day"></i>
                            Day of Week <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" value="{{ ucfirst($selectedDay ?? '') }}" readonly>
                        <input type="hidden" name="day_of_week" value="{{ $selectedDay ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-alt"></i>
                            Date <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" value="{{ $selectedDate ?? '' }}" readonly>
                        <input type="hidden" name="schedule_date" value="{{ $selectedDate ?? '' }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-play"></i>
                            Start Time <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" value="{{ $startTime ?? '' }}" readonly>
                        <input type="hidden" name="start_time" value="{{ $startTime ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-stop"></i>
                            End Time <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" value="{{ $endTime ?? '' }}" readonly>
                        <input type="hidden" name="end_time" value="{{ $endTime ?? '' }}">
                    </div>
                </div>

                <!-- User input fields -->
                <div class="form-group">
                    <label>
                        <i class="fas fa-repeat"></i>
                        Recurrence Type <span class="required">*</span>
                    </label>
                    <select name="recurrence_type" class="form-control" required>
                        <option value="" disabled selected>Select recurrence pattern</option>
                        <option value="none">None (One-time session)</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="biweekly">Bi-weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-alt"></i>
                            Recurrence Start Date <span class="required">*</span>
                        </label>
                        <input type="date" name="recurrence_start_date" class="form-control"
                            value="{{ $selectedDate ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-check"></i>
                            Recurrence End Date
                        </label>
                        <input type="date" name="recurrence_end_date" class="form-control">
                        <small style="color: var(--gray-light); margin-top: 5px; display: block;">
                            Leave empty for no end date
                        </small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-toggle-on"></i>
                            Status
                        </label>
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">Active (Schedule will be visible)</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-users"></i>
                            Session Type
                        </label>
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_group_schedule" value="1">
                                <span>Group Session</span>
                            </label>
                            <small style="color: var(--gray-light);">
                                (Multiple participants allowed)
                            </small>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label><i class="fas fa-ruler"></i> Available Spots </label>
                    <input type="number" name="avaliable_spots" class="form-control">
                    @error('avaliable_spots')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label>
                        <i class="fas fa-sticky-note"></i>
                        Additional Notes
                    </label>
                    <textarea name="notes" class="form-control" rows="3"
                        placeholder="Any additional information about this schedule..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="fas fa-save"></i>
                        Create Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#schedule-form').on('submit', function(e) {
                e.preventDefault();
                var member_id = $('#member_id').val();
                var trainer_id = $('#member_id').val();
                var course_id = $('#course_id').val();
                // Validate recurrence dates
                var startDate = $('input[name="recurrence_start_date"]').val();
                var endDate = $('input[name="recurrence_end_date"]').val();

                if (endDate && endDate < startDate) {
                    showNotification('End date must be after start date', 'error');
                    return false;
                }

                // Show loading state
                var submitBtn = $('#submit-btn');
                var originalText = submitBtn.html();
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Creating...');

                // Submit form
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showNotification('Schedule created successfully!', 'success');
                            setTimeout(function() {
                                window.location.href = response.redirect_url ||
                                    '{{ route('classInstance.createSchedule', ['member_id' => 'member_id', 'trainer_id' => 'trainer_id', 'course_id' => 'course_id']) }}';
                            }, 1500);
                        } else {
                            showNotification(response.message || 'Error creating schedule',
                                'error');
                            submitBtn.prop('disabled', false);
                            submitBtn.html(originalText);
                        }
                    },
                    error: function(xhr) {
                        var errorMsg = 'Something went wrong';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        }
                        showNotification(errorMsg, 'error');
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                    }
                });
            });

            function showNotification(message, type) {
                $('.schedule-notification').remove();

                var notification = $(`
                <div class="schedule-notification alert alert-${type === 'success' ? 'success' : 'danger'}" 
                     style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <div style="flex: 1;">${message}</div>
                        <button type="button" class="close" style="background: none; border: none; color: inherit; font-size: 1.5rem;" onclick="$(this).parent().parent().remove()">&times;</button>
                    </div>
                </div>
            `);

                $('body').append(notification);

                if (type === 'success') {
                    setTimeout(function() {
                        notification.fadeOut(300, function() {
                            $(this).remove();
                        });
                    }, 3000);
                }
            }
        });
    </script>
@endsection
