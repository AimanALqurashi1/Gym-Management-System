{{-- resources/views/attendance/class_attendance.blade.php --}}
@extends('layouts.home')

@section('title', 'Mark Attendance - ' . $classInstance->course->name)

@section('css')
    <style>
        /* Attendance Container - Light Theme */
        .attendance-container {
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

        /* Class Info Card - Light Theme */
        .class-info-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .info-content .label {
            color: var(--gray);
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .info-content .value {
            color: var(--dark);
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Stats Grid - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
            font-size: 2rem;
            margin: 0;
        }

        .stat-card p {
            color: var(--gray);
            margin: 5px 0 0;
        }

        .stat-card.present h3 {
            color: var(--success);
        }

        .stat-card.late h3 {
            color: var(--warning);
        }

        .stat-card.absent h3 {
            color: var(--danger);
        }

        /* ADDED: Payment Status Styles */
        .payment-status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .payment-status-paid {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .payment-status-partial {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
        }

        .payment-status-pending {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
        }

        .payment-status-overdue {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }

        /* ADDED: Overdue member row */
        .member-row-overdue {
            background: rgba(220, 53, 69, 0.05);
            border-left: 3px solid var(--danger);
        }

        .member-row-overdue td {
            background: rgba(220, 53, 69, 0.03);
        }

        .payment-warning-text {
            color: var(--danger);
            font-size: 0.7rem;
            display: block;
            margin-top: 3px;
        }

        /* Attendance Form - Light Theme */
        .attendance-form {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Attendance Table - Light Theme */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th {
            background: rgba(0, 0, 0, 0.02);
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .attendance-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
        }

        .attendance-table tbody tr:hover {
            background: var(--primary-light);
        }

        .attendance-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Member Info - Light Theme */
        .member-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .member-avatar {
            width: 35px;
            height: 35px;
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
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Form Controls - Light Theme */
        .status-select {
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 6px 12px;
            color: var(--dark);
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .status-select:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .status-select:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .time-input {
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 6px 12px;
            color: var(--dark);
            width: 100px;
            transition: var(--transition);
        }

        .time-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .time-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Notes Input */
        .notes-input {
            background: #f5f5f5;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            padding: 6px;
            color: var(--dark);
            width: 100%;
            transition: var(--transition);
        }

        .notes-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .notes-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Buttons - Light Theme */
        .btn-save {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(255, 85, 0, 0.2);
        }

        .btn-save:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-save:disabled {
            background: var(--gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray);
            border: 2px solid var(--border-color);
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Quick Actions - Light Theme */
        .quick-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .quick-btn {
            background: #f5f5f5;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 16px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .quick-btn:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
        }

        .quick-btn i {
            color: var(--primary);
        }

        /* Alert Warning - Light Theme */
        .alert-warning {
            background: rgba(220, 53, 69, 0.05);
            border-left: 4px solid var(--danger);
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .alert-warning i {
            color: var(--danger);
            margin-right: 10px;
        }

        .alert-warning strong {
            color: var(--danger);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .attendance-container {
                padding: 20px;
            }

            .class-info-card {
                grid-template-columns: 1fr;
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .attendance-table {
                display: block;
                overflow-x: auto;
            }

            .member-info {
                flex-direction: column;
                text-align: center;
            }

            .member-avatar {
                margin-bottom: 5px;
            }
        }

        @media (max-width: 576px) {
            .attendance-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                flex-direction: column;
            }

            .quick-btn {
                width: 100%;
                justify-content: center;
            }

            .btn-save {
                width: 100%;
                justify-content: center;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 8px 10px;
                font-size: 0.8rem;
            }

            .time-input {
                width: 80px;
            }
        }

        /* Animation for form */
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

        .attendance-form,
        .class-info-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Loading state */
        .btn-save.loading {
            opacity: 0.7;
            cursor: wait;
        }

        .btn-save.loading i {
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
    <div class="attendance-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-clipboard-check"></i>
                Mark Attendance
            </h1>
            <div class="breadcrumb">
                <a href="{{ route('attendance.today') }}">Today's Attendance</a> /
                <span>Mark Attendance</span>
            </div>
        </div>

        <!-- Class Info Card -->
        <div class="class-info-card">
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="info-content">
                    <div class="label">Course</div>
                    <div class="value">{{ $classInstance->course->name ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="info-content">
                    <div class="label">Trainer</div>
                    <div class="value">{{ $classInstance->trainer->name ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="info-content">
                    <div class="label">Date</div>
                    <div class="value">{{ Carbon\Carbon::parse($classInstance->start_date)->format('l, F j, Y') }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="info-content">
                    <div class="label">Time</div>
                    <div class="value">
                        {{ Carbon\Carbon::parse($classInstance->start_time)->format('g:i A') }} -
                        {{ Carbon\Carbon::parse($classInstance->end_time)->format('g:i A') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $stats['total_enrolled'] }}</h3>
                <p>Total Enrolled</p>
            </div>
            <div class="stat-card present">
                <h3>{{ $stats['present'] }}</h3>
                <p>Present</p>
            </div>
            <div class="stat-card late">
                <h3>{{ $stats['late'] }}</h3>
                <p>Late</p>
            </div>
            <div class="stat-card absent">
                <h3>{{ $stats['absent'] }}</h3>
                <p>Absent</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <button type="button" class="quick-btn" onclick="setAllStatus('present')">
                <i class="fas fa-check-circle"></i>
                Mark All Present
            </button>
            <button type="button" class="quick-btn" onclick="setAllStatus('late')">
                <i class="fas fa-exclamation-circle"></i>
                Mark All Late
            </button>
            <button type="button" class="quick-btn" onclick="setAllStatus('absent')">
                <i class="fas fa-times-circle"></i>
                Mark All Absent
            </button>
            <button type="button" class="quick-btn" onclick="clearAllStatus()">
                <i class="fas fa-undo"></i>
                Clear All
            </button>
        </div>

        <!-- Attendance Form -->
        <form action="{{ route('attendance.mark', $classInstance->id) }}" method="POST" class="attendance-form"
            id="attendanceForm">
            @csrf

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendance as $item)
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar">
                                        @if (!empty($item['member']->photo))
                                            <img src="{{ asset('admin/uploads/' . $item['member']->photo) }}"
                                                alt="{{ $item['member']->name }}">
                                        @else
                                            <i class="fas fa-user-circle"></i>
                                        @endif
                                    </div>
                                    <span>{{ $item['member']->name }}</span>
                                </div>
                                <input type="hidden" name="attendance[{{ $loop->index }}][member_id]"
                                    value="{{ $item['member']->id }}">
                            </td>
                            <td>{{ $item['member']->code ?? 'N/A' }}</td>
                            <td>
                                <select name="attendance[{{ $loop->index }}][status]"
                                    class="status-select status-{{ $loop->index }}">
                                    <option value="">Not Marked</option>
                                    <option value="present"
                                        {{ $item['attendance_status'] == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="late" {{ $item['attendance_status'] == 'late' ? 'selected' : '' }}>
                                        Late</option>
                                    <option value="absent" {{ $item['attendance_status'] == 'absent' ? 'selected' : '' }}>
                                        Absent</option>
                                </select>
                            </td>
                            <td>
                                <input type="time" name="attendance[{{ $loop->index }}][check_in]"
                                    class="time-input check-in-{{ $loop->index }}"
                                    value="{{ $item['check_in_time'] ?? '' }}" step="60">
                            </td>
                            <td>
                                <input type="time" name="attendance[{{ $loop->index }}][check_out]"
                                    class="time-input check-out-{{ $loop->index }}"
                                    value="{{ $item['check_out_time'] ?? '' }}" step="60">
                            </td>
                            <td>
                                <input type="text" name="attendance[{{ $loop->index }}][notes]" class="form-control"
                                    style="background: var(--dark-light); border: 1px solid var(--border-color); border-radius: 5px; padding: 6px; color: white;"
                                    value="{{ $item['notes'] ?? '' }}" placeholder="Notes">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px;">
                <a href="{{ route('attendance.today') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i>
                    Save Attendance
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function setAllStatus(status) {
            const selects = document.querySelectorAll('[name^="attendance"][name$="[status]"]');
            selects.forEach(select => {
                select.value = status;
            });
        }

        function clearAllStatus() {
            const selects = document.querySelectorAll('[name^="attendance"][name$="[status]"]');
            selects.forEach(select => {
                select.value = '';
            });

            const times = document.querySelectorAll('.time-input');
            times.forEach(input => {
                input.value = '';
            });
        }

        $(document).ready(function() {
            // Auto-calculate check-out based on class end time
            const classEndTime = '{{ $classInstance->end_time }}';

            $('[name^="attendance"][name$="[check_in]"]').on('change', function() {
                const index = $(this).attr('class').match(/check-in-(\d+)/)[1];
                const checkOutField = $(`.check-out-${index}`);

                if ($(this).val() && !checkOutField.val()) {
                    // Suggest class end time as default check-out
                    checkOutField.val(classEndTime.substring(0, 5));
                }
            });
        });
    </script>
@endsection
