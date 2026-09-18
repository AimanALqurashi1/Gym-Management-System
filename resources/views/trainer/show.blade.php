@extends('layouts.home')

@section('title', 'Trainer Details - ' . $trainer->name)

@section('css')
    <style>
        .trainer-details-container {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .trainer-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .trainer-avatar-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .trainer-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .trainer-avatar-large i {
            font-size: 4rem;
            color: white;
        }

        .trainer-info h2 {
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .trainer-info p {
            color: var(--gray);
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .trainer-info p i {
            color: var(--primary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-card h3 {
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--gray);
            margin: 0;
        }

        .courses-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .courses-section h3 {
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .courses-section h3 i {
            color: var(--primary);
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .course-card {
            background: #fafafa;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .course-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.1);
        }

        .course-name {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .course-level {
            color: var(--primary);
            font-size: 0.85rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .course-duration {
            color: var(--gray);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-back {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-back:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Additional styles for trainer edit page - Light Theme */
        .edit-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .edit-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .edit-card .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 25px;
            border-bottom: none;
        }

        .edit-card .card-header h2 {
            color: white;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-card .card-body {
            padding: 30px;
        }

        .edit-card .form-group label {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .edit-card .form-control {
            background: #f5f5f5;
            border: 1px solid var(--border-color);
            color: var(--dark);
        }

        .edit-card .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .edit-card .current-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 15px;
            border: 3px solid var(--primary);
        }

        .edit-card .btn-primary {
            background: var(--primary);
            color: white;
        }

        .edit-card .btn-primary:hover {
            background: var(--primary-dark);
        }

        .edit-card .btn-secondary {
            background: transparent;
            color: var(--dark);
            border: 2px solid var(--border-color);
        }

        .edit-card .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .trainer-details-container {
                padding: 20px;
            }

            .trainer-header {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .trainer-info h2 {
                font-size: 1.5rem;
            }

            .trainer-info p {
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .courses-grid {
                grid-template-columns: 1fr;
            }

            .course-card {
                padding: 12px;
            }

            .edit-container {
                padding: 20px;
            }

            .edit-card .card-body {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .trainer-avatar-large {
                width: 100px;
                height: 100px;
            }

            .trainer-avatar-large i {
                font-size: 2.5rem;
            }

            .trainer-info h2 {
                font-size: 1.3rem;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }
        }

        /* Animation for cards */
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

        .course-card {
            animation: fadeInUp 0.3s ease forwards;
        }

        .course-card:nth-child(1) {
            animation-delay: 0s;
        }

        .course-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .course-card:nth-child(3) {
            animation-delay: 0.1s;
        }

        .course-card:nth-child(4) {
            animation-delay: 0.15s;
        }

        .course-card:nth-child(5) {
            animation-delay: 0.2s;
        }

        .course-card:nth-child(6) {
            animation-delay: 0.25s;
        }
    </style>
@endsection

@section('content')
    <div class="trainer-details-container">
        <div class="trainer-header">
            <div class="trainer-avatar-large">
                @if ($trainer->photo)
                    <img src="{{ asset('admin/uploads/' . $trainer->photo) }}" alt="{{ $trainer->name }}">
                @else
                    @if ($trainer->gender == 'female')
                        <i class="fas fa-female"></i>
                    @else
                        <i class="fas fa-user-tie"></i>
                    @endif
                @endif
            </div>
            <div class="trainer-info">
                <h2>{{ $trainer->name }}</h2>
                <p><i class="fas fa-id-card"></i> Code: {{ $trainer->code ?? 'N/A' }}</p>
                <p><i class="fas fa-envelope"></i> {{ $trainer->email ?? 'N/A' }}</p>
                <p><i class="fas fa-phone"></i> {{ $trainer->phone ?? 'N/A' }}</p>
                <p><i class="fas fa-map-marker-alt"></i> {{ $trainer->address ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $stats['total_courses'] }}</h3>
                <p>Courses</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['total_schedules'] }}</h3>
                <p>Schedules</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['total_classes'] }}</h3>
                <p>Classes</p>
            </div>
        </div>

        <div class="courses-section">
            <h3 style="color: white; margin-bottom: 15px;">
                <i class="fas fa-book-open" style="color: var(--primary);"></i>
                Assigned Courses
            </h3>

            @if ($trainer->courses->count() > 0)
                <div class="courses-grid">
                    @foreach ($trainer->courses as $course)
                        <div class="course-card">
                            <div class="course-name">{{ $course->name }}</div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i> {{ ucfirst($course->level) }}
                            </div>
                            <div class="course-duration">
                                <i class="fas fa-clock"></i> {{ $course->duration }} months
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: var(--gray-light); text-align: center; padding: 40px;">
                    No courses assigned to this trainer yet.
                </p>
            @endif
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ route('trainer.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Trainers
            </a>
        </div>
    </div>
@endsection
