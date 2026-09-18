@extends('layouts.home')

@section('title', 'Member Details')

@section('css')
    <style>
        /* Member Details Container - Light Theme */
        .member-details-container {
            padding: 30px;
        }

        /* Profile Header - Light Theme */
        .profile-header {
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 85, 0, 0.05));
            border: 1px solid var(--border-primary);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }

        /* Profile Avatar - Light Theme */
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 5px 20px rgba(255, 85, 0, 0.3);
            transition: var(--transition);
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(255, 85, 0, 0.4);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar i {
            font-size: 4rem;
            color: white;
        }

        /* Profile Info - Light Theme */
        .profile-info h2 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .profile-info h2 i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .profile-info p {
            color: var(--gray);
            margin: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .profile-info p i {
            color: var(--primary);
            width: 20px;
        }

        /* Member Status Badge */
        .member-status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 10px;
        }

        .status-active-member {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-inactive-member {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .status-pending-member {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        /* Back Button - Light Theme */
        .back-button {
            margin-left: auto;
        }

        .btn-back {
            background: white;
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            transition: var(--transition);
            border: 1px solid var(--border-primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .btn-back:hover {
            background: var(--primary);
            color: white;
            transform: translateX(-5px);
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-back i {
            transition: var(--transition);
        }

        .btn-back:hover i {
            transform: translateX(-3px);
        }

        /* Details Grid - Light Theme */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        /* Detail Cards - Light Theme */
        .detail-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .detail-card:hover {
            border-color: var(--border-primary);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            background: linear-gradient(135deg, white, #fafafa);
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--primary);
            font-size: 1.3rem;
        }

        .card-title h3 {
            color: var(--dark);
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .card-content {
            padding: 20px;
        }

        /* Info List */
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--gray);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: var(--dark);
            font-weight: 500;
        }

        .info-value i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Membership Card */
        .membership-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 1px solid var(--border-primary);
        }

        .membership-card .card-title {
            background: rgba(255, 85, 0, 0.05);
        }

        .membership-plan {
            text-align: center;
            padding: 15px;
        }

        .plan-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .plan-price {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .plan-dates {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .expiry-warning {
            color: var(--warning);
            font-weight: 600;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .expiry-danger {
            color: var(--danger);
        }

        /* Progress Section */
        .progress-section {
            margin-top: 15px;
        }

        .progress-item {
            margin-bottom: 15px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            color: var(--gray);
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .progress-bar-container {
            width: 100%;
            height: 8px;
            background: var(--secondary-light);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }

        .btn-edit {
            background: var(--primary);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .btn-edit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-subscribe {
            background: var(--success);
            color: white;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .btn-subscribe:hover {
            background: var(--success-dark);
            transform: translateY(-2px);
        }

        .btn-schedule {
            background: var(--info);
            color: white;
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.2);
        }

        .btn-schedule:hover {
            background: #138496;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .member-details-container {
                padding: 20px;
            }

            .details-grid {
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .member-details-container {
                padding: 15px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .profile-info h2 {
                font-size: 1.5rem;
                justify-content: center;
            }

            .profile-info p {
                justify-content: center;
            }

            .back-button {
                margin-left: 0;
                width: 100%;
            }

            .btn-back {
                width: 100%;
                justify-content: center;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .member-details-container {
                padding: 10px;
            }

            .profile-header {
                padding: 20px;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-avatar i {
                font-size: 3rem;
            }

            .profile-info h2 {
                font-size: 1.3rem;
            }

            .card-title {
                padding: 15px;
            }

            .card-content {
                padding: 15px;
            }

            .plan-name {
                font-size: 1.2rem;
            }
        }

        /* Animations */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .profile-header {
            animation: fadeInLeft 0.4s ease forwards;
        }

        .detail-card:nth-child(1) {
            animation: fadeInRight 0.4s ease forwards;
        }

        .detail-card:nth-child(2) {
            animation: fadeInRight 0.5s ease forwards;
        }

        .detail-card:nth-child(3) {
            animation: fadeInRight 0.6s ease forwards;
        }

        /* Loading Skeleton */
        .skeleton-loader {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
        }

        .skeleton-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }

        .skeleton-text {
            height: 20px;
            margin: 10px 0;
        }

        .skeleton-title {
            height: 30px;
            width: 60%;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Tooltip */
        [data-tooltip] {
            position: relative;
            cursor: help;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 5px;
            display: none;
        }

        [data-tooltip]:hover:before {
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="member-details-container">
        <div class="profile-header">
            <div class="profile-avatar">
                @if ($member->photo)
                    <img src="{{ asset('admin/uploads/' . $member->photo) }}" alt="{{ $member->name }}">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
            </div>
            <div class="profile-info">
                <h2>{{ $member->name }}</h2>
                <p><i class="fas fa-envelope"></i> {{ $member->email ?? 'N/A' }}</p>
                <p><i class="fas fa-phone"></i> {{ $member->phone ?? 'N/A' }}</p>
                <p><i class="fas fa-id-card"></i> Member ID: {{ $member->code ?? 'N/A' }}</p>
            </div>
            <div class="back-button">
                <a href="{{ url()->previous() }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

    </div>
@endsection
