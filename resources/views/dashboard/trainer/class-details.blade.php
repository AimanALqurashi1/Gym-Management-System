{{-- resources/views/trainer/class-details.blade.php --}}
@extends('layouts.home')

@section('title', 'Class Details - ' . $class->course->name)

@section('css')
    <style>
        /* Class Container - Light Theme */
        .class-container {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
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
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 85, 0, 0.05));
            border: 1px solid var(--border-primary);
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
            transition: var(--transition);
        }

        .info-item:hover {
            transform: translateX(5px);
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .info-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .info-content .label {
            color: var(--gray);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-content .value {
            color: var(--dark);
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Stats Grid - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-card h3 {
            color: var(--dark);
            font-size: 2rem;
            margin: 0;
            font-weight: 700;
        }

        .stat-card p {
            color: var(--gray);
            margin-top: 8px;
            font-weight: 500;
        }

        /* Attendance Form - Light Theme */
        .attendance-form {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Section Title */
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark);
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-primary);
        }

        .section-title i {
            color: var(--primary);
        }

        /* Attendance Table - Light Theme */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table thead {
            background: var(--primary);
        }

        .attendance-table th {
            color: white;
            font-weight: 700;
            padding: 15px 12px;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Montserrat', sans-serif;
        }

        .attendance-table td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            vertical-align: middle;
        }

        .attendance-table tbody tr {
            transition: var(--transition);
        }

        .attendance-table tbody tr:hover {
            background: var(--primary-light);
        }

        /* Member Cell - Light Theme */
        .member-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-avatar i {
            font-size: 1.2rem;
            color: var(--primary);
        }

        .member-info {
            display: flex;
            flex-direction: column;
        }

        .member-name {
            font-weight: 600;
            color: var(--dark);
        }

        .member-code {
            font-size: 0.75rem;
            color: var(--gray);
        }

        /* Form Controls - Light Theme */
        .status-select,
        .time-input {
            background: var(--secondary-light);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 15px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Open Sans', sans-serif;
            font-size: 0.85rem;
        }

        .status-select:focus,
        .time-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .status-select:hover,
        .time-input:hover {
            border-color: var(--primary);
        }

        /* Status Badge Colors for Select */
        .status-select option.present {
            color: var(--success);
        }

        .status-select option.late {
            color: var(--warning);
        }

        .status-select option.absent {
            color: var(--danger);
        }

        .status-select option.excused {
            color: var(--info);
        }

        /* Quick Actions - Light Theme */
        .quick-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .quick-btn {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 10px 20px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .quick-btn i {
            color: var(--primary);
        }

        .quick-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .quick-btn:hover i {
            color: white;
        }

        /* Save Button - Light Theme */
        .btn-save {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 25px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-save:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        /* Note Input */
        .note-input {
            background: var(--secondary-light);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 8px 12px;
            color: var(--dark);
            width: 100%;
            min-width: 150px;
        }

        .note-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Summary Section */
        .summary-section {
            margin-top: 30px;
            padding: 20px;
            background: var(--secondary-light);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-count {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .summary-label {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Checkbox for Select All */
        .select-all {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .select-all input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .summary-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .class-container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .class-info-card {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .attendance-table {
                display: block;
                overflow-x: auto;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }

            .member-cell {
                flex-direction: column;
                text-align: center;
            }

            .quick-actions {
                justify-content: center;
            }

            .status-select,
            .time-input {
                width: 100%;
                min-width: auto;
            }

            .btn-save {
                width: 100%;
                justify-content: center;
            }

            .summary-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .info-item {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .class-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.3rem;
            }

            .class-info-card,
            .attendance-form {
                padding: 15px;
            }

            .info-icon {
                width: 40px;
                height: 40px;
            }

            .info-icon i {
                font-size: 1.2rem;
            }

            .info-content .value {
                font-size: 1rem;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .quick-btn {
                flex: 1;
                justify-content: center;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .class-info-card,
        .stat-card,
        .attendance-form {
            animation: fadeInUp 0.4s ease forwards;
        }

        /* Loading State */
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

        /* Tooltip */
        .info-item {
            position: relative;
        }

        /* Success Message */
        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: var(--success);
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: var(--danger);
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="class-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-clipboard-check"></i>
                {{ $class->course->name ?? 'Class Details' }}
            </h1>
            <a href="{{ route('trainer.schedule') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Schedule
            </a>
        </div>

        <!-- Class Info -->
        <div class="class-info-card">
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="info-content">
                    <div class="label">Date</div>
                    <div class="value">{{ $class->start_date->format('l, F j, Y') }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="info-content">
                    <div class="label">Time</div>
                    <div class="value">{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} -
                        {{ \Carbon\Carbon::parse($class->end_time)->format('g:i A') }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="info-content">
                    <div class="label">Location</div>
                    <div class="value">{{ $class->location ?? 'Main Studio' }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="info-content">
                    <div class="label">Capacity</div>
                    <div class="value">{{ $class->member->count() }}/{{ $class->total_spots }}</div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            @php
                $present = $class->member->where('pivot.attendance_status', 'present')->count();
                $late = $class->member->where('pivot.attendance_status', 'late')->count();
                $absent = $class->member->where('pivot.attendance_status', 'absent')->count();
                $notMarked = $class->member->whereNull('pivot.attendance_status')->count();
            @endphp
            <div class="stat-card">
                <h3 style="color: var(--success);">{{ $present }}</h3>
                <p>Present</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--warning);">{{ $late }}</h3>
                <p>Late</p>
            </div>
            <div class="stat-card">
                <h3 style="color: var(--danger);">{{ $absent }}</h3>
                <p>Absent</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <button type="button" class="quick-btn" onclick="setAllStatus('present')">
                <i class="fas fa-check-circle"></i> All Present
            </button>
            <button type="button" class="quick-btn" onclick="setAllStatus('late')">
                <i class="fas fa-exclamation-circle"></i> All Late
            </button>
            <button type="button" class="quick-btn" onclick="setAllStatus('absent')">
                <i class="fas fa-times-circle"></i> All Absent
            </button>
            <button type="button" class="quick-btn" onclick="clearAll()">
                <i class="fas fa-undo"></i> Clear All
            </button>
        </div>

        <!-- Attendance Form -->
        <form action="{{ route('trainer.class.attendance', $class->id) }}" method="POST" class="attendance-form">
            @csrf

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Status</th>
                        <th>Check In Time</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendance as $index => $item)
                        <tr>
                            <td>
                                <div class="member-cell">
                                    <div class="member-avatar">
                                        @if ($item['member']->photo)
                                            <img src="{{ asset('admin/uploads/' . $item['member']->photo) }}"
                                                alt="{{ $item['member']->name }}">
                                        @else
                                            <i class="fas fa-user-circle"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div>{{ $item['member']->name }}</div>
                                        <small style="color: var(--gray-light);">{{ $item['member']->code ?? '' }}</small>
                                    </div>
                                </div>
                                <input type="hidden" name="attendance[{{ $index }}][member_id]"
                                    value="{{ $item['member']->id }}">
                            </td>
                            <td>
                                <select name="attendance[{{ $index }}][status]"
                                    class="status-select status-{{ $index }}">
                                    <option value="">Not Marked</option>
                                    <option value="present" {{ $item['status'] == 'present' ? 'selected' : '' }}>Present
                                    </option>
                                    <option value="late" {{ $item['status'] == 'late' ? 'selected' : '' }}>Late</option>
                                    <option value="absent" {{ $item['status'] == 'absent' ? 'selected' : '' }}>Absent
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input type="time" name="attendance[{{ $index }}][check_in]"
                                    class="time-input check-in-{{ $index }}" value="{{ $item['check_in'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="attendance[{{ $index }}][notes]" class="form-control"
                                    placeholder="Notes" value="{{ $item['note'] ?? '' }}"
                                    style="background: var(--dark-light); border: 1px solid var(--border-color); color: white; padding: 6px; border-radius: 5px;">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i>
                Save Attendance
            </button>
        </form>
    </div>

    <script>
        function setAllStatus(status) {
            const selects = document.querySelectorAll('[name^="attendance"][name$="[status]"]');
            selects.forEach(select => {
                select.value = status;
            });
        }

        function clearAll() {
            const selects = document.querySelectorAll('[name^="attendance"][name$="[status]"]');
            selects.forEach(select => {
                select.value = '';
            });

            const times = document.querySelectorAll('.time-input');
            times.forEach(input => {
                input.value = '';
            });
        }
    </script>
@endsection
