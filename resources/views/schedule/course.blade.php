@extends('layouts.home')
@section('css')
    <style>
        /* Schedule Management Styles - Light Theme */
        h2 {
            color: var(--dark);
            margin-bottom: 30px;
            font-size: 1.8rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }

        h2 i {
            color: var(--primary);
            margin-right: 10px;
        }

        h3 {
            color: var(--dark);
            margin: 30px 0 20px;
            font-size: 1.3rem;
            text-align: center;
        }

        /* Course Info Section - Light Theme */
        .course-info {
            background: linear-gradient(135deg, var(--primary-light), white);
            color: var(--dark);
            padding: 25px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid var(--border-primary);
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .course-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary);
        }

        .course-icon {
            width: 70px;
            height: 70px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: var(--primary);
        }

        .course-details {
            flex: 1;
        }

        .course-details h3 {
            margin: 0 0 10px 0;
            font-size: 24px;
            text-align: left;
            color: var(--dark);
        }

        .course-details p {
            margin: 5px 0;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray);
        }

        .course-details i {
            width: 20px;
            color: var(--primary);
        }

        /* Row layout for form groups */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        .form-group.disabled {
            opacity: 0.5;
        }

        .form-group.disabled::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.05);
            pointer-events: none;
            border-radius: var(--border-radius);
        }

        .lock-icon {
            position: absolute;
            top: 40px;
            right: 15px;
            color: var(--primary);
            z-index: 10;
            font-size: 18px;
            background: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: var(--gray);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        label i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Custom Select Styles - Light Theme */
        .custom-select {
            position: relative;
            width: 100%;
        }

        .custom-select.disabled {
            pointer-events: none;
        }

        .custom-select.disabled .select-selected {
            background: #f5f5f5;
            border-color: var(--border-color);
        }

        /* Selected value display */
        .select-selected {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
            position: relative;
            min-height: 80px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .select-selected:hover {
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.1);
        }

        .select-selected.active {
            border-color: var(--primary);
            box-shadow: 0 5px 20px rgba(255, 85, 0, 0.15);
        }

        .select-selected .placeholder {
            color: var(--gray);
            font-style: italic;
        }

        .select-selected i.fa-chevron-down {
            margin-left: auto;
            color: var(--primary);
            transition: transform 0.3s ease;
            font-size: 18px;
        }

        .select-selected.active i.fa-chevron-down {
            transform: rotate(180deg);
        }

        /* Selected preview */
        .selected-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .preview-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .preview-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .preview-icon i {
            font-size: 24px;
            color: var(--primary);
        }

        .preview-info h4 {
            margin: 0;
            font-size: 16px;
            color: var(--dark);
            font-weight: 600;
        }

        .preview-info p {
            margin: 5px 0 0;
            font-size: 13px;
            color: var(--gray);
        }

        .preview-info small {
            font-size: 11px;
            color: var(--gray);
            display: inline-block;
            background: #f5f5f5;
            padding: 2px 8px;
            border-radius: 12px;
            margin-top: 5px;
        }

        ·preview-info small i {
            color: var(--primary);
        }

        /* Dropdown container */
        .select-items {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            margin-top: 10px;
            max-height: 350px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .select-items.show {
            display: block;
        }

        /* Individual option cards */
        .select-item {
            padding: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .select-item:last-child {
            border-bottom: none;
        }

        .select-item:hover {
            background: var(--primary-light);
        }

        .select-item.selected {
            background: rgba(255, 85, 0, 0.08);
            border-left: 4px solid var(--primary);
        }

        .item-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .item-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .item-avatar i {
            font-size: 24px;
            color: var(--primary);
        }

        .item-details {
            flex: 1;
        }

        .item-details h4 {
            margin: 0;
            font-size: 16px;
            color: var(--dark);
            font-weight: 600;
        }

        .item-details .member-code,
        .item-details .trainer-code {
            margin: 4px 0;
            font-size: 12px;
            color: var(--primary);
            font-weight: 500;
        }

        .item-details .member-plan,
        .item-details .trainer-plan {
            font-size: 11px;
            color: var(--gray);
            display: inline-block;
            background: #f5f5f5;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .item-check {
            color: var(--primary);
            opacity: 0;
            transition: opacity 0.2s ease;
            font-size: 18px;
        }

        .select-item.selected .item-check {
            opacity: 1;
        }

        /* Search box */
        .dropdown-search {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
        }

        .dropdown-search input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            font-size: 14px;
            background: #f5f5f5;
            color: var(--dark);
        }

        .dropdown-search input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .dropdown-search i {
            position: absolute;
            left: 28px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            pointer-events: none;
        }

        /* No results */
        .no-results {
            padding: 30px;
            text-align: center;
            color: var(--gray);
            font-style: italic;
        }

        /* Hidden native select (for form submission) */
        .native-select-hidden {
            display: none;
        }

        /* Class Instance Section - Light Theme */
        .class-instance-section {
            margin-top: 40px;
            padding: 30px;
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 1px dashed var(--primary);
        }

        .class-instance-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .class-instance-header h3 {
            margin: 0;
            color: var(--primary);
        }

        .class-instance-header h3 i {
            margin-right: 8px;
        }

        .btn-add {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-add:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 85, 0, 0.3);
        }

        .btn-add:disabled {
            background: var(--gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-add i {
            font-size: 14px;
        }

        .selection-status {
            margin-top: 15px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: var(--border-radius);
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border-color);
        }

        .selection-status i {
            color: var(--primary);
        }

        .selection-status.warning {
            background: rgba(255, 193, 7, 0.08);
            color: var(--warning);
            border-color: rgba(255, 193, 7, 0.2);
        }

        .selection-status.warning i {
            color: var(--warning);
        }

        .selection-status.success {
            background: rgba(40, 167, 69, 0.08);
            color: var(--success);
            border-color: rgba(40, 167, 69, 0.2);
        }

        .selection-status.success i {
            color: var(--success);
        }

        /* Remove old light theme specific styles */
        .container,
        .select-selected,
        .dropdown-search input,
        .class-instance-section {
            transition: var(--transition);
        }

        /* Add smooth scrolling for dropdowns */
        .select-items {
            scrollbar-width: thin;
            scrollbar-color: var(--primary) #f0f0f0;
        }

        .select-items::-webkit-scrollbar {
            width: 6px;
        }

        .select-items::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 20px;
        }

        .select-items::-webkit-scrollbar-thumb {
            background-color: var(--primary);
            border-radius: 20px;
        }

        /* Course Schedules Section - Light Theme */
        .course-schedules-section {
            margin: 40px 0 30px;
            padding: 25px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark);
            margin-bottom: 25px;
            font-size: 1.4rem;
            font-family: 'Montserrat', sans-serif;
        }

        .section-title i {
            color: var(--primary);
            font-size: 1.6rem;
        }

        .section-title span {
            background: var(--primary-light);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-left: 15px;
        }

        /* Schedule Cards Grid */
        .schedules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 20px;
        }

        /* Schedule Card - Light Theme */
        .schedule-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .schedule-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        /* Card Header */
        .schedule-card .card-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            padding: 15px 20px;
            border-bottom: 2px solid var(--primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .schedule-card .card-header .day-badge {
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .schedule-card .card-header .time-badge {
            background: #f5f5f5;
            color: var(--dark);
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .schedule-card .card-header .time-badge i {
            color: var(--primary);
            font-size: 0.8rem;
        }

        /* Card Body */
        .schedule-card .card-body {
            padding: 20px;
        }

        /* Payment Status Badge */
        .payment-status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
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

        /* Trainer Info - Light Theme */
        .trainer-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .trainer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid var(--primary);
        }

        .trainer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .trainer-avatar i {
            font-size: 24px;
            color: var(--primary);
        }

        .trainer-details {
            flex: 1;
        }

        .trainer-details h4 {
            color: var(--dark);
            font-size: 1.1rem;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .trainer-details .trainer-specialization {
            color: var(--gray);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trainer-details .trainer-specialization i {
            color: var(--primary);
            font-size: 0.8rem;
        }

        /* Schedule Details - Light Theme */
        .schedule-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
            font-size: 0.95rem;
        }

        .detail-item i {
            width: 20px;
            color: var(--primary);
            font-size: 1rem;
        }

        .detail-item .label {
            color: var(--gray);
            min-width: 80px;
        }

        .detail-item .value {
            color: var(--dark);
            font-weight: 500;
        }

        /* Members List - Light Theme */
        .members-list {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .members-list .title {
            color: var(--gray);
            font-size: 0.85rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .members-list .title i {
            color: var(--primary);
        }

        .member-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .member-tag {
            background: var(--primary-light);
            border: 1px solid var(--border-primary);
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 0.85rem;
            color: var(--dark);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .member-tag i {
            color: var(--primary);
            font-size: 0.75rem;
        }

        /* Card Footer - Light Theme */
        .schedule-card .card-footer {
            padding: 15px 20px;
            background: #fafafa;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge.group {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge.individual {
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
            border: 1px solid var(--border-primary);
        }

        .spots-available {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Recurrence Info - Light Theme */
        .recurrence-info {
            margin-top: 12px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .recurrence-info i {
            color: var(--primary);
        }

        /* Empty State - Light Theme */
        .no-schedules {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 2px dashed var(--border-color);
        }

        .no-schedules i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-schedules p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .schedules-grid {
                grid-template-columns: 1fr;
            }

            .detail-item {
                flex-wrap: wrap;
            }

            .detail-item .label {
                min-width: 70px;
            }
        }

        /* Schedule Card States - Light Theme */
        .schedule-card.clickable {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .schedule-card.clickable.has-spots {
            border-color: var(--success);
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.2);
        }

        .schedule-card.clickable.has-spots:hover {
            transform: translateY(-5px) scale(1.02);
            border-color: var(--success);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
        }

        .schedule-card.clickable.has-spots::after {
            content: '+ Add Member';
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--success);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .schedule-card.clickable.has-spots:hover::after {
            opacity: 1;
        }

        .schedule-card.full {
            opacity: 0.8;
            border-color: var(--danger);
            background: rgba(220, 53, 69, 0.03);
            position: relative;
        }

        .schedule-card.full::before {
            content: 'FULL';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            background: var(--danger);
            color: white;
            padding: 8px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            opacity: 0.8;
            z-index: 10;
            pointer-events: none;
        }

        .schedule-card.individual {
            border-color: var(--primary);
            opacity: 0.9;
        }

        .spots-available.available {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .spots-available.full {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        /* Payment Summary Card - Light Theme */
        .payment-summary-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .payment-summary-title {
            color: var(--dark);
            font-size: 0.85rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .payment-summary-title i {
            color: var(--primary);
        }

        .payment-amount {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .payment-due {
            font-size: 0.75rem;
            color: var(--warning);
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding: 1.5rem">
        <h2><i class="fas fa-calendar-alt"></i> Schedule Management</h2>

        <!-- Course Info - Always at top, always selected -->
        <div class="course-info">
            <div class="course-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="course-details">
                <h3>{{ $course_data->name ?? 'Course Name' }}</h3>
                <p><i class="fas fa-tag"></i> Code: {{ $course_data->code ?? 'N/A' }}</p>
                <p><i class="fas fa-clock"></i> Duration: {{ $course_data->duration ?? 'N/A' }}</p>
                <p><i class="fas fa-info-circle"></i> {{ $course_data->description ?? 'No description available' }}</p>
            </div>
            <!-- Hidden input for course ID -->
            <input type="hidden" id="courseId" value="{{ $course_data->id ?? '' }}">
        </div>
        <!-- Course Schedules Section -->
        <div class="course-schedules-section">
            <div class="section-title">
                <i class="fas fa-calendar-week"></i>
                Course Schedules
                <span>{{ $courseSchedules->count() }} {{ Str::plural('Schedule', $courseSchedules->count()) }}</span>
            </div>

            @if ($courseSchedules->count() > 0)
                <div class="schedules-grid">
                    @foreach ($courseSchedules as $schedule)
                        @php
                            $memberCount = $schedule->member->count();
                            $totalSpots = $schedule->is_group ? 4 : 1;
                            $availableSpots = $totalSpots - $memberCount;
                            $startTimeFormatted = Carbon\Carbon::parse($schedule->start_time)->format('g:i A');
                            $endTimeFormatted = Carbon\Carbon::parse($schedule->end_time)->format('g:i A');

                            // Get trainer photo
                            $trainerPhotoUrl = '';
                            if ($schedule->trainer) {
                                if (!empty($schedule->trainer->photo) && $schedule->trainer->photo !== null) {
                                    $trainerPhotoUrl = asset('admin/uploads') . '/' . $schedule->trainer->photo;
                                } else {
                                    $trainerPhotoUrl = asset('admin/uploads/trainer-default.png');
                                }
                            }
                        @endphp

                        <div class="schedule-card {{ $schedule->is_group ? ($memberCount < $totalSpots ? 'clickable has-spots' : 'full') : 'individual' }}"
                            @if ($schedule->is_group && $memberCount < $totalSpots) onclick="window.location.href='{{ route('classInstance.showToAdd', $schedule->id) }}'"
                                style="cursor: pointer;"
                            @elseif(!$schedule->is_group)
                                title="Individual Session - Cannot add more members"
                            @elseif($memberCount >= $totalSpots)
                                title="This group session is full" @endif>

                            <div class="card-header">
                                <span class="day-badge">
                                    <i class="fas fa-calendar-day"></i> {{ ucfirst($schedule->day_of_week) }}
                                </span>
                                <span class="time-badge">
                                    <i class="fas fa-clock"></i> {{ $startTimeFormatted }} - {{ $endTimeFormatted }}
                                </span>
                            </div>

                            <div class="card-body">
                                <!-- Trainer Info -->
                                @if ($schedule->trainer)
                                    <div class="trainer-info">
                                        <div class="trainer-avatar">
                                            <img src="{{ $trainerPhotoUrl }}" alt="{{ $schedule->trainer->name }}">
                                        </div>
                                        <div class="trainer-details">
                                            <h4>{{ $schedule->trainer->name }}</h4>
                                            <div class="trainer-specialization">
                                                <i class="fas fa-dumbbell"></i>
                                                {{ $schedule->trainer->specialization ?? 'General Trainer' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Schedule Details -->
                                <div class="schedule-details">
                                    <div class="detail-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span class="label">Start Date:</span>
                                        <span
                                            class="value">{{ Carbon\Carbon::parse($schedule->recurrence_start_date)->format('M d, Y') }}</span>
                                    </div>

                                    @if ($schedule->recurrence_end_date)
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-check"></i>
                                            <span class="label">End Date:</span>
                                            <span
                                                class="value">{{ Carbon\Carbon::parse($schedule->recurrence_end_date)->format('M d, Y') }}</span>
                                        </div>
                                    @endif

                                    <div class="detail-item">
                                        <i class="fas fa-repeat"></i>
                                        <span class="label">Recurrence:</span>
                                        <span class="value">{{ ucfirst($schedule->recurrence_type ?? 'None') }}</span>
                                    </div>

                                    @if ($schedule->note)
                                        <div class="detail-item">
                                            <i class="fas fa-sticky-note"></i>
                                            <span class="label">Note:</span>
                                            <span class="value">{{ Str::limit($schedule->note, 30) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Members List -->
                                @if ($memberCount > 0)
                                    <div class="members-list">
                                        <div class="title">
                                            <i class="fas fa-users"></i> Enrolled Members ({{ $memberCount }})
                                        </div>
                                        <div class="member-tags">
                                            @foreach ($schedule->member->take(3) as $member)
                                                <span class="member-tag">
                                                    <i class="fas fa-user"></i> {{ Str::limit($member->name, 15) }}
                                                </span>
                                            @endforeach
                                            @if ($memberCount > 3)
                                                <span class="member-tag">+{{ $memberCount - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <span class="status-badge {{ $schedule->is_group ? 'group' : 'individual' }}">
                                    <i class="fas {{ $schedule->is_group ? 'fa-users' : 'fa-user' }}"></i>
                                    {{ $schedule->is_group ? 'Group Session' : 'Individual Session' }}
                                </span>

                                @if ($schedule->is_group)
                                    @php
                                        $memberCount = $schedule->member->count();
                                        // Get the first (or most relevant) class instance
                                        $classInstance = $schedule->classInstances->first();
                                        $totalSpots = $classInstance ? $classInstance->total_spots : 0;
                                        $availableSpots = $totalSpots - $memberCount;
                                    @endphp
                                    <span class="spots-available {{ $availableSpots > 0 ? 'available' : 'full' }}">
                                        <i class="fas fa-chair"></i>
                                        @if ($availableSpots > 0 && $totalSpots > 0)
                                            {{ $availableSpots }} / {{ $totalSpots }} spots available
                                        @else
                                            <i class="fas fa-times-circle"></i> Full
                                        @endif
                                    </span>
                                @endif
                            </div>



                            <!-- Recurrence Info -->
                            @if ($schedule->recurrence_type && $schedule->recurrence_type != 'none')
                                <div class="recurrence-info">
                                    <i class="fas fa-sync-alt"></i>
                                    Repeats {{ $schedule->recurrence_type }}
                                    @if ($schedule->recurrence_end_date)
                                        until {{ Carbon\Carbon::parse($schedule->recurrence_end_date)->format('M d, Y') }}
                                    @else
                                        (No end date)
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-schedules">
                    <i class="fas fa-calendar-times"></i>
                    <p>No schedules have been created for this course yet.</p>
                </div>
            @endif
        </div>
        <!-- Selection Section -->
        <div class="form-row">
            <!-- Trainer Selector -->
            <div class="form-group {{ $trainerId && !$memberID ? '' : ($trainerId && $memberID ? 'disabled' : '') }}">
                @if ($trainerId && $memberID)
                    <div class="lock-icon" title="Trainer is locked">
                        <i class="fas fa-lock"></i>
                    </div>
                @endif
                <label><i class="fas fa-chalkboard-teacher"></i> Select Trainer</label>

                <!-- Custom Select -->
                <div class="custom-select {{ $trainerId && $memberID ? 'disabled' : '' }}" id="trainerCustomSelect">
                    <!-- Selected value display -->
                    <div class="select-selected"
                        onclick="{{ $trainerId && $memberID ? '' : "toggleDropdown('trainerDropdown')" }}"
                        id="trainerSelectDisplay">
                        <div class="selected-preview" id="trainerPreview">
                            @if ($trainerId && $trainer_data)
                                @php
                                    $selectedTrainer = $trainer_data;
                                    $trainerPhotoUrl = '';
                                    if ($selectedTrainer) {
                                        if (!empty($selectedTrainer->photo) && $selectedTrainer->photo !== null) {
                                            $trainerPhotoUrl = asset('admin/uploads') . '/' . $selectedTrainer->photo;
                                        } else {
                                            $trainerPhotoUrl = asset('admin/uploads/trainer-default.png');
                                        }
                                    }
                                @endphp
                                <div class="preview-icon">
                                    <img src="{{ $trainerPhotoUrl }}" alt="{{ $selectedTrainer->name ?? 'Trainer' }}">
                                </div>
                                <div class="preview-info">
                                    <h4>{{ $selectedTrainer->name ?? 'Trainer' }}</h4>
                                    <p><i class="fas fa-id-card"></i> {{ $selectedTrainer->code ?? 'N/A' }}</p>
                                    <small><i class="fas fa-dumbbell"></i>
                                        {{ $selectedTrainer->specialization ?? 'General' }}</small>
                                </div>
                            @else
                                <div class="preview-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="preview-info">
                                    <h4 class="placeholder">Choose a trainer</h4>
                                    <p>Click to see all trainers</p>
                                </div>
                            @endif
                        </div>
                        @if (!($trainerId && $memberID))
                            <i class="fas fa-chevron-down"></i>
                        @endif
                    </div>

                    <!-- Dropdown - Only show if trainer is not locked -->
                    @if (!($trainerId && $memberID))
                        <div class="select-items" id="trainerDropdown">
                            <!-- Search box -->
                            <div class="dropdown-search">
                                <i class="fas fa-search"></i>
                                <input type="text" id="trainerSearch" placeholder="Search by name or ID..."
                                    onkeyup="filterTrainers()">
                            </div>

                            <!-- Options -->
                            <div id="trainerOptions">
                                @if ($trainerId && !$memberID && $trainer_data && !is_iterable($trainer_data))
                                    @php
                                        $trainer = $trainer_data;
                                        $trainerPhotoUrl = '';
                                        if (!empty($trainer->photo) && $trainer->photo !== null) {
                                            $trainerPhotoUrl = asset('admin/uploads') . '/' . $trainer->photo;
                                        } else {
                                            $trainerPhotoUrl = asset('admin/uploads/trainer-default.png');
                                        }
                                    @endphp
                                    <div class="select-item trainer-item selected"
                                        onclick="selectTrainer({{ $trainer->id }}, '{{ $trainer->name }}', '{{ $trainer->specialization ?? 'General' }}', '{{ $trainer->code ?? 'N/A' }}', '{{ $trainerPhotoUrl }}')"
                                        data-name="{{ strtolower($trainer->name) }}"
                                        data-code="{{ strtolower($trainer->code ?? '') }}"
                                        data-specialization="{{ strtolower($trainer->specialization ?? '') }}">
                                        <div class="item-avatar">
                                            <img src="{{ $trainerPhotoUrl }}" alt="{{ $trainer->name }}">
                                        </div>
                                        <div class="item-details">
                                            <h4>{{ $trainer->name }}</h4>
                                            <div class="trainer-code">
                                                <i class="fas fa-id-card"></i> {{ $trainer->code ?? 'No Code' }}
                                            </div>
                                            <span class="trainer-plan">
                                                <i class="fas fa-dumbbell"></i>
                                                {{ $trainer->specialization ?? 'General' }}
                                            </span>
                                        </div>
                                        <i class="fas fa-check-circle item-check"></i>
                                    </div>
                                @elseif(is_iterable($trainer_data))
                                    @forelse($trainer_data as $trainer)
                                        @php
                                            $trainerPhotoUrl = '';
                                            if (!empty($trainer->photo) && $trainer->photo !== null) {
                                                $trainerPhotoUrl = asset('admin/uploads') . '/' . $trainer->photo;
                                            } else {
                                                $trainerPhotoUrl = asset('admin/uploads/trainer-default.png');
                                            }
                                        @endphp
                                        <div class="select-item trainer-item"
                                            onclick="selectTrainer({{ $trainer->id }}, '{{ $trainer->name }}', '{{ $trainer->specialization ?? 'General' }}', '{{ $trainer->code ?? 'N/A' }}', '{{ $trainerPhotoUrl }}')"
                                            data-name="{{ strtolower($trainer->name) }}"
                                            data-code="{{ strtolower($trainer->code ?? '') }}"
                                            data-specialization="{{ strtolower($trainer->specialization ?? '') }}">
                                            <div class="item-avatar">
                                                <img src="{{ $trainerPhotoUrl }}" alt="{{ $trainer->name }}">
                                            </div>
                                            <div class="item-details">
                                                <h4>{{ $trainer->name }}</h4>
                                                <div class="trainer-code">
                                                    <i class="fas fa-id-card"></i> {{ $trainer->code ?? 'No Code' }}
                                                </div>
                                                <span class="trainer-plan">
                                                    <i class="fas fa-dumbbell"></i>
                                                    {{ $trainer->specialization ?? 'General' }}
                                                </span>
                                            </div>
                                            <i class="fas fa-check-circle item-check"></i>
                                        </div>
                                    @empty
                                        <div class="no-results">
                                            <i class="fas fa-exclamation-circle"></i> No trainers found
                                        </div>
                                    @endforelse
                                @else
                                    <div class="no-results">
                                        <i class="fas fa-exclamation-circle"></i> No trainers available
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Hidden native select -->
                <select name="trainer_id" id="trainerSelect" class="native-select-hidden" required>
                    <option value="">Select a trainer</option>
                    @if ($trainerId && $trainer_data && !is_iterable($trainer_data))
                        <option value="{{ $trainer_data->id }}" selected>{{ $trainer_data->name }}</option>
                    @elseif(is_iterable($trainer_data))
                        @foreach ($trainer_data as $trainer)
                            <option value="{{ $trainer->id }}" {{ $trainerId == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Member Selector -->
            <div class="form-group">
                <label><i class="fas fa-users"></i> Select Member</label>

                <!-- Custom Select -->
                <div class="custom-select" id="memberCustomSelect">
                    <!-- Selected value display -->
                    <div class="select-selected" onclick="toggleDropdown('memberDropdown')" id="memberSelectDisplay">
                        <div class="selected-preview" id="memberPreview">
                            @if ($memberID && $member_data && !is_iterable($member_data))
                                @php
                                    $selectedMember = $member_data;
                                    $photoUrl = '';
                                    if (!empty($selectedMember->photo) && $selectedMember->photo !== null) {
                                        $photoUrl = asset('admin/uploads') . '/' . $selectedMember->photo;
                                    } else {
                                        // Check if gender property exists
                                        $gender = 'male'; // default
                                        if (
                                            property_exists($selectedMember, 'gender') &&
                                            $selectedMember->gender !== null
                                        ) {
                                            $gender = $selectedMember->gender;
                                        } elseif (isset($selectedMember->gender) && $selectedMember->gender !== null) {
                                            $gender = $selectedMember->gender;
                                        }

                                        $photoUrl =
                                            $gender == 'female'
                                                ? asset('admin/uploads/femaleLogo.jpg')
                                                : asset('admin/uploads/maleLogo.png');
                                    }
                                @endphp
                                <div class="preview-icon">
                                    <img src="{{ $photoUrl }}" alt="{{ $selectedMember->name ?? 'Member' }}">
                                </div>
                                <div class="preview-info">
                                    <h4>{{ $selectedMember->name ?? 'Member' }}</h4>
                                    <p><i class="fas fa-id-card"></i> {{ $selectedMember->code ?? 'N/A' }}</p>
                                    <small><i class="fas fa-tag"></i> {{ $selectedMember->plan ?? 'No Plan' }}</small>
                                </div>
                            @else
                                <div class="preview-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="preview-info">
                                    <h4 class="placeholder">Choose a member</h4>
                                    <p>Click to see all members</p>
                                </div>
                            @endif
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <!-- Dropdown -->
                    <div class="select-items" id="memberDropdown">
                        <!-- Search box -->
                        <div class="dropdown-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="memberSearch" placeholder="Search by name or ID..."
                                onkeyup="filterMembers()">
                        </div>

                        <!-- Options -->
                        <div id="memberOptions">
                            @if ($memberID && $member_data && !is_iterable($member_data))
                                @php
                                    $member = $member_data;
                                    $photoUrl = '';
                                    if (!empty($member->photo) && $member->photo !== null) {
                                        $photoUrl = asset('admin/uploads') . '/' . $member->photo;
                                    } else {
                                        $photoUrl =
                                            ($member->gender ?? 'male') == 'female'
                                                ? asset('admin/uploads/femaleLogo.jpg')
                                                : asset('admin/uploads/maleLogo.png');
                                    }
                                @endphp
                                <!-- Show the specific member (just like trainer selector does) -->
                                <div class="select-item member-item selected"
                                    onclick="selectMember({{ $member->id }}, '{{ $member->name }}', '{{ $member->plan ?? 'No Plan' }}', '{{ $member->code ?? 'N/A' }}', '{{ $photoUrl }}')"
                                    data-name="{{ strtolower($member->name) }}"
                                    data-code="{{ strtolower($member->code ?? '') }}"
                                    data-plan="{{ strtolower($member->plan ?? '') }}">
                                    <div class="item-avatar">
                                        <img src="{{ $photoUrl }}" alt="{{ $member->name }}">
                                    </div>
                                    <div class="item-details">
                                        <h4>{{ $member->name }}</h4>
                                        <div class="member-code">
                                            <i class="fas fa-id-card"></i> {{ $member->code ?? 'No Code' }}
                                        </div>
                                        <span class="member-plan">
                                            <i class="fas fa-tag"></i> {{ $member->plan ?? 'No Plan' }}
                                        </span>
                                    </div>
                                    <i class="fas fa-check-circle item-check"></i>
                                </div>
                            @elseif(is_iterable($member_data))
                                @forelse($member_data as $member)
                                    @php
                                        $photoUrl = '';
                                        if (!empty($member->photo) && $member->photo !== null) {
                                            $photoUrl = asset('admin/uploads') . '/' . $member->photo;
                                        } else {
                                            // Check if gender property exists
                                            $gender = 'male'; // default
                                            if (property_exists($member, 'gender') && $member->gender !== null) {
                                                $gender = $member->gender;
                                            } elseif (isset($member->gender) && $member->gender !== null) {
                                                $gender = $member->gender;
                                            }

                                            $photoUrl =
                                                $gender == 'female'
                                                    ? asset('admin/uploads/femaleLogo.jpg')
                                                    : asset('admin/uploads/maleLogo.png');
                                        }
                                    @endphp
                                    <div class="select-item member-item"
                                        onclick="selectMember({{ $member->id }}, '{{ $member->name }}', '{{ $member->plan ?? 'No Plan' }}', '{{ $member->code ?? 'N/A' }}', '{{ $photoUrl }}')"
                                        data-name="{{ strtolower($member->name) }}"
                                        data-code="{{ strtolower($member->code ?? '') }}"
                                        data-plan="{{ strtolower($member->plan ?? '') }}">
                                        <div class="item-avatar">
                                            <img src="{{ $photoUrl }}" alt="{{ $member->name }}">
                                        </div>
                                        <div class="item-details">
                                            <h4>{{ $member->name }}</h4>
                                            <div class="member-code">
                                                <i class="fas fa-id-card"></i> {{ $member->code ?? 'No Code' }}
                                            </div>
                                            <span class="member-plan">
                                                <i class="fas fa-tag"></i> {{ $member->plan ?? 'No Plan' }}
                                            </span>
                                        </div>
                                        <i class="fas fa-check-circle item-check"></i>
                                    </div>
                                @empty
                                    <div class="no-results">
                                        <i class="fas fa-exclamation-circle"></i> No members found
                                    </div>
                                @endforelse
                            @else
                                <div class="no-results">
                                    <i class="fas fa-exclamation-circle"></i> No members available
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hidden native select -->
                <select name="member_id" id="memberSelect" class="native-select-hidden" required>
                    <option value="">Select a member</option>
                    @if ($memberID && $member_data && !is_iterable($member_data))
                        <option value="{{ $member_data->id }}" selected>{{ $member_data->name }}</option>
                    @elseif(is_iterable($member_data))
                        @foreach ($member_data as $member)
                            <option value="{{ $member->id }}" {{ $memberID == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <!-- Selection Status Message -->
        <div
            class="selection-status {{ $trainerId && $memberID ? 'success' : ($trainerId && !$memberID ? 'warning' : '') }}">
            @if ($trainerId && $memberID)
                <i class="fas fa-check-circle"></i>
                <span>Both trainer and member are pre-selected and locked. You can proceed to add class instances.</span>
            @elseif($trainerId && !$memberID)
                <i class="fas fa-info-circle"></i>
                <span>Trainer is pre-selected. Please select a member to continue.</span>
            @else
                <i class="fas fa-info-circle"></i>
                <span>Please select both a trainer and a member to add class instances.</span>
            @endif
        </div>

        <!-- Class Instance Section -->
        <div class="class-instance-section">
            <div class="class-instance-header">
                <h3><i class="fas fa-clock"></i> Class Instances</h3>
                <button class="btn-add" id="addClassInstanceBtn">
                    <i class="fas fa-plus"></i> Add New Instance
                </button>
            </div>

            @if (!($trainerId && $memberID) && !($trainerId && !$memberID))
                <div class="selection-status warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Please select a trainer and member first to add class instances.</span>
                </div>
            @elseif($trainerId && !$memberID)
                <div class="selection-status warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Please select a member to add class instances.</span>
                </div>
            @else
                <div class="selection-status success">
                    <i class="fas fa-check-circle"></i>
                    <span>Ready to add class instances. Click the button above to continue.</span>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#addClassInstanceBtn', function(e) {
            e.preventDefault();

            var trainerId = $('#trainerSelect').val();
            var memberId = $('#memberSelect').val();
            var courseId = $('#courseId').val();

            if (!trainerId || !memberId || !courseId) {
                alert('Please ensure a course, trainer, and member are selected.');
                return false;
            }

            var url = '{{ route('classInstance.createSchedule') }}' +
                '?course_id=' + encodeURIComponent(courseId) +
                '&trainer_id=' + encodeURIComponent(trainerId) +
                '&member_id=' + encodeURIComponent(memberId);

            window.location.href = url;
        });

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            if (!dropdown) return;

            const allDropdowns = document.querySelectorAll('.select-items');
            allDropdowns.forEach(d => {
                if (d.id !== id && d.classList.contains('show')) {
                    d.classList.remove('show');
                    if (d.previousElementSibling) {
                        d.previousElementSibling.classList.remove('active');
                    }
                }
            });

            dropdown.classList.toggle('show');
            const selectedDisplay = dropdown.previousElementSibling;
            if (selectedDisplay) {
                selectedDisplay.classList.toggle('active');
            }
        }

        function selectMember(id, name, plan, code, photoUrl) {
            document.getElementById('memberSelect').value = id;

            document.getElementById('memberPreview').innerHTML = `
                <div class="preview-icon">
                    <img src="${photoUrl}" alt="${name}">
                </div>
                <div class="preview-info">
                    <h4>${name}</h4>
                    <p><i class="fas fa-id-card"></i> ${code}</p>
                    <small><i class="fas fa-tag"></i> ${plan}</small>
                </div>
            `;

            document.querySelectorAll('.member-item').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');

            document.getElementById('memberDropdown').classList.remove('show');
            const memberDisplay = document.getElementById('memberDropdown').previousElementSibling;
            if (memberDisplay) {
                memberDisplay.classList.remove('active');
            }
        }

        function selectTrainer(id, name, specialization, code, photoUrl) {
            document.getElementById('trainerSelect').value = id;

            document.getElementById('trainerPreview').innerHTML = `
                <div class="preview-icon">
                    <img src="${photoUrl}" alt="${name}">
                </div>
                <div class="preview-info">
                    <h4>${name}</h4>
                    <p><i class="fas fa-id-card"></i> ${code}</p>
                    <small><i class="fas fa-dumbbell"></i> ${specialization}</small>
                </div>
            `;

            document.querySelectorAll('.trainer-item').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');

            document.getElementById('trainerDropdown').classList.remove('show');
            const trainerDisplay = document.getElementById('trainerDropdown').previousElementSibling;
            if (trainerDisplay) {
                trainerDisplay.classList.remove('active');
            }
        }

        function filterMembers() {
            const searchTerm = document.getElementById('memberSearch').value.toLowerCase();
            const items = document.querySelectorAll('.member-item');

            items.forEach(item => {
                const name = item.dataset.name;
                const code = item.dataset.code;
                const plan = item.dataset.plan;

                if (name.includes(searchTerm) || code.includes(searchTerm) || plan.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function filterTrainers() {
            const searchTerm = document.getElementById('trainerSearch').value.toLowerCase();
            const items = document.querySelectorAll('.trainer-item');

            items.forEach(item => {
                const name = item.dataset.name;
                const code = item.dataset.code;
                const specialization = item.dataset.specialization;

                if (name.includes(searchTerm) || code.includes(searchTerm) || specialization.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.custom-select')) {
                document.querySelectorAll('.select-items').forEach(dropdown => {
                    dropdown.classList.remove('show');
                    if (dropdown.previousElementSibling) {
                        dropdown.previousElementSibling.classList.remove('active');
                    }
                });
            }
        });

        document.getElementById('memberSearch')?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        document.getElementById('trainerSearch')?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
@endsection
