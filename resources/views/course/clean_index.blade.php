@extends('layouts.home')
@section('css')
    <style>
        /* Course Cards Container - Light Theme */
        .courses-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            padding: 30px;
            width: 100%;
        }

        /* Course Card Styles - Light Theme */
        .course-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary);
        }

        .course-image {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
            width: 100%;
            object-fit: cover;
        }

        .course-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.6) 100%);
            display: flex;
            align-items: flex-end;
            padding: 20px;
            color: white;
        }

        .course-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
            z-index: 2;
        }

        .course-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .course-header h3 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 5px;
            margin-top: 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .course-code {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            background: var(--primary-light);
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #f5f5f5;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.9rem;
            color: #ffc107;
        }

        .course-rating span:last-child {
            color: var(--gray);
        }

        .course-description {
            color: var(--gray);
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 0.95rem;
            flex: 1;
        }

        .course-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            color: var(--gray);
            font-size: 0.95rem;
            flex-wrap: wrap;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f5f5f5;
            padding: 5px 12px;
            border-radius: 50px;
        }

        .stat i {
            color: var(--primary);
            font-size: 1rem;
        }

        .instructors {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 10px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .instructor-avatars {
            display: flex;
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 600;
            border: 2px solid white;
            margin-right: -10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .avatar:nth-child(2) {
            background: var(--accent);
        }

        .avatar:nth-child(3) {
            background: var(--success);
        }

        .instructor-count {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .course-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Montserrat', sans-serif;
        }

        .price small {
            font-size: 0.7rem;
            font-weight: 400;
            color: var(--gray);
        }

        .enroll-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
            font-family: 'Montserrat', sans-serif;
        }

        .enroll-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .enroll-btn:active {
            transform: translateY(0);
        }

        /* Class Card Styles - Level 2 - Light Theme */
        .class-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .class-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary);
        }

        .class-card .card-header {
            background: linear-gradient(135deg, var(--primary-light), white);
            color: var(--dark);
            padding: 20px;
            position: relative;
            border-bottom: 1px solid var(--border-primary);
        }

        .class-card .card-header h3 {
            font-size: 1.4rem;
            margin-bottom: 5px;
            margin-top: 0;
            color: var(--dark);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .class-card .class-code {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .class-card .card-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .class-card .card-body {
            padding: 20px;
            flex: 1;
        }

        .class-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            color: var(--gray);
            font-size: 0.95rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f5f5f5;
            padding: 5px 12px;
            border-radius: 50px;
        }

        .info-item i {
            color: var(--primary);
        }

        .schedule {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border-color);
        }

        .schedule i {
            color: var(--primary);
        }

        .teacher {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .teacher-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .teacher-info {
            flex: 1;
        }

        .teacher-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .teacher-title {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .progress-section {
            margin-top: 20px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .progress-bar {
            height: 8px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 10px;
            transition: width 0.3s ease;
            box-shadow: 0 0 5px var(--primary);
        }

        .class-footer {
            padding: 20px;
            background: #fafafa;
            display: flex;
            gap: 15px;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.95rem;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn i {
            font-size: 1rem;
        }

        /* No data message - Light Theme */
        .no-courses {
            grid-column: 1/-1;
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .no-courses i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-courses p {
            color: var(--gray);
            font-size: 1.2rem;
            margin: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .courses-container {
                padding: 20px;
                gap: 20px;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .course-header h3 {
                font-size: 1.2rem;
            }

            .course-stats {
                flex-wrap: wrap;
                gap: 10px;
            }

            .class-footer {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .class-info {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .courses-container {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .course-card,
            .class-card {
                max-width: 100%;
            }

            .course-header {
                flex-direction: column;
                gap: 10px;
            }

            .course-rating {
                align-self: flex-start;
            }
        }

        /* Animation for cards */
        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .course-card,
        .class-card {
            animation: cardAppear 0.5s ease forwards;
        }

        /* Hover effects for icons */
        .course-card:hover .enroll-btn,
        .class-card:hover .btn-primary {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        /* Custom scrollbar for containers - Light Theme */
        .courses-container::-webkit-scrollbar {
            width: 8px;
        }

        .courses-container::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 4px;
        }

        .courses-container::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        .courses-container::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
@endsection

@section('content')
    <div class="courses-container">
        @forelse($data as $course)
            <div class="course-card"
                onclick="window.location='{{ route(
                    'Schedule.MemberSchedule',
                    request()->routeIs('trainer.trainerClases')
                        ? [$course->id, $trainer_data->id, 0]
                        : (request()->routeIs('member.MemberCourses')
                            ? [$course->id, 0, $member_data->id]
                            : [$course->id, 0, 0]),
                ) }}'">

                @if (!empty($course->photo))
                    <img src="{{ asset('admin/uploads') . '/' . $course->photo }}" class="course-image" class="course-image">
                @else
                    <div class="course-image"
                        style="background: linear-gradient(135deg, var(--primary), var(--primary-dark))">
                        <div class="course-overlay">
                            <i class="fas fa-dumbbell" style="font-size: 3em;"></i>
                        </div>
                    </div>
                @endif

                <span class="course-category">{{ $course->category ?? 'Fitness' }}</span>

                <div class="course-content">
                    <div class="course-header">
                        <div>
                            <h3>{{ $course->name }}</h3>
                            <span class="course-code">{{ $course->code ?? $course->category }}</span>
                        </div>
                        <div class="course-rating">
                            <i class="fas fa-star"></i>
                            <span>4.8</span>
                        </div>
                    </div>

                    <p class="course-description">
                        {{ $course->description ?? 'No description available' }}
                    </p>

                    <div class="course-stats">
                        <span class="stat">
                            <i class="fas fa-users"></i>
                            {{ $course->members_joint_course ?? 0 }}
                        </span>
                        <span class="stat">
                            <i class="fas fa-book-open"></i>
                            {{ $course->lessons_count ?? 1 }} lessons
                        </span>
                        <span class="stat">
                            <i class="fas fa-clock"></i>
                            {{ $course->duration ?? 3 }} months
                        </span>
                    </div>

                    <div class="instructors">
                        <div class="instructor-avatars">
                            <div class="avatar">JD</div>
                            <div class="avatar">SW</div>
                            <div class="avatar">MK</div>
                        </div>
                        <span class="instructor-count">+3 instructors</span>
                    </div>

                    <div class="course-footer">
                        <div class="price">
                            ${{ $course->price ?? 99 }} <small>/course</small>
                        </div>
                        <button class="enroll-btn" onclick="event.stopPropagation();">
                            <i class="fas fa-graduation-cap"></i> Enroll Now
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-courses">
                <i class="fas fa-book-open"></i>
                <p>No courses found.</p>
            </div>
        @endforelse
    </div>

    <!-- Class Card Example (commented out or remove if not needed) -->
    {{-- 
    <div class="class-card">
        <div class="card-header">
            <h3>Data Structures & Algorithms</h3>
            <div class="class-code">CS301</div>
            <span class="card-badge">Room 301</span>
        </div>
        <div class="card-body">
            <div class="class-info">
                <div class="info-item">
                    <i class="fas fa-users"></i>
                    <span>35 Students</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-chart-line"></i>
                    <span>75% Complete</span>
                </div>
            </div>

            <div class="schedule">
                <i class="fas fa-clock"></i>
                Mon, Wed • 10:00 AM - 11:30 AM
            </div>

            <div class="teacher">
                <div class="teacher-avatar">DW</div>
                <div class="teacher-info">
                    <div class="teacher-name">Dr. David Wilson</div>
                    <div class="teacher-title">CS Professor</div>
                </div>
            </div>

            <div class="progress-section">
                <div class="progress-header">
                    <span>Course Progress</span>
                    <span>75%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%"></div>
                </div>
            </div>
        </div>
        <div class="class-footer">
            <button class="btn btn-primary"><i class="fas fa-eye"></i> View Details</button>
            <button class="btn btn-outline"><i class="fas fa-video"></i> Join Class</button>
        </div>
    </div>
    --}}
@endsection
