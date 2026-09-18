{{-- resources/views/reports/trainer/select.blade.php --}}
@extends('layouts.home')

@section('title', 'Select Trainer for Performance Report')

@section('css')
    <style>
        /* Select Container - Light Theme */
        .select-container {
            padding: 30px;
            max-width: 600px;
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

        /* Form Group - Light Theme */
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

        /* Form Control - Light Theme */
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
            box-shadow: 0 0 0 4px var(--primary-light);
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

        /* Date Range - Light Theme */
        .date-range {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        /* ADDED: Trainer Preview Section */
        .trainer-preview {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .trainer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .trainer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .trainer-avatar i {
            font-size: 1.5rem;
            color: white;
        }

        .trainer-info h4 {
            color: var(--dark);
            margin-bottom: 3px;
        }

        .trainer-info p {
            color: var(--gray);
            font-size: 0.8rem;
            margin: 0;
        }

        /* ADDED: Help Text */
        .help-text {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .help-text i {
            color: var(--primary);
            font-size: 0.7rem;
        }

        /* ADDED: Info Box */
        .info-box {
            background: var(--primary-light);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border-primary);
        }

        .info-box i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .info-box p {
            color: var(--dark);
            margin: 0;
            font-size: 0.85rem;
        }

        /* Button - Light Theme */
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            width: 100%;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* ADDED: Form Row */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .select-container {
                padding: 20px;
            }

            .select-card {
                padding: 20px;
            }

            .date-range {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .trainer-preview {
                flex-direction: column;
                text-align: center;
            }

            .info-box {
                text-align: center;
                flex-direction: column;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
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

            .form-control {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .trainer-avatar {
                width: 40px;
                height: 40px;
            }

            .trainer-avatar i {
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

        .select-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* ADDED: Loading State */
        .loading {
            text-align: center;
            padding: 20px;
            color: var(--gray);
        }

        .loading i {
            font-size: 1.5rem;
            color: var(--primary);
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
    <div class="select-container">
        <div class="select-card">
            <h2>
                <i class="fas fa-chalkboard-teacher"></i>
                Trainer Performance Report
            </h2>

            <form action="{{ route('reports.trainer.performance') }}" method="GET">
                <div class="form-group">
                    <label><i class="fas fa-user-tie"></i> Select Trainer</label>
                    <select name="trainer_id" class="form-control" required>
                        <option value="">-- Choose a trainer --</option>
                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ $trainerId == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }} ({{ $trainer->specialization ?? 'General' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="date-range">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-start"></i> Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ $startDate->format('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-calendar-end"></i> End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-chart-bar"></i>
                    Generate Report
                </button>
            </form>
        </div>
    </div>
@endsection
