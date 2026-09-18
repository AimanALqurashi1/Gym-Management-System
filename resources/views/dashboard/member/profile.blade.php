{{-- resources/views/member/profile.blade.php --}}
@extends('layouts.home')

@section('title', 'My Profile')

@section('css')
    <style>
        /* Profile Container - Light Theme */
        .profile-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Profile Card - Light Theme */
        .profile-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .profile-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        /* Profile Header - Light Theme */
        .profile-header {
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 85, 0, 0.05));
            padding: 40px;
            text-align: center;
            border-bottom: 2px solid var(--primary);
            position: relative;
        }

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
            margin: 0 auto 20px;
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
            font-size: 3.5rem;
            color: white;
        }

        .profile-header h2 {
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .profile-header p {
            color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .profile-header p i {
            color: var(--primary);
        }

        /* Profile Body - Light Theme */
        .profile-body {
            padding: 30px;
        }

        /* Edit Icon Overlay */
        .edit-avatar-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            color: var(--primary);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .edit-avatar-btn:hover {
            background: var(--primary);
            color: white;
            transform: rotate(15deg);
        }

        /* Form Groups - Light Theme */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: var(--dark);
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: var(--secondary-light);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            font-size: 1rem;
            transition: var(--transition);
            font-family: 'Open Sans', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .form-control[readonly] {
            background: var(--primary-light);
            border-color: var(--border-primary);
            color: var(--dark);
            cursor: not-allowed;
            opacity: 0.8;
        }

        .form-control[readonly]:focus {
            box-shadow: none;
        }

        /* Textarea */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Select Dropdown */
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
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
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

        .btn-save i {
            font-size: 1rem;
        }

        /* Cancel Button */
        .btn-cancel {
            background: transparent;
            color: var(--gray);
            border: 2px solid var(--border-color);
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-right: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-cancel:hover {
            border-color: var(--danger);
            color: var(--danger);
            transform: translateY(-2px);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        /* Info Sections */
        .info-section {
            margin-bottom: 30px;
        }

        .info-section h3 {
            color: var(--dark);
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-primary);
            display: inline-block;
        }

        .info-section h3 i {
            color: var(--primary);
            margin-right: 8px;
        }

        /* Stats in Profile */
        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .profile-stat-card {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: var(--transition);
        }

        .profile-stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
        }

        .profile-stat-value {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .profile-stat-label {
            color: var(--gray);
            font-size: 0.8rem;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Member Since */
        .member-since {
            text-align: center;
            padding: 15px;
            background: var(--primary-light);
            border-radius: 10px;
            margin-top: 20px;
            color: var(--primary);
            font-weight: 600;
        }

        .member-since i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-container {
                padding: 20px;
            }

            .profile-header {
                padding: 30px 20px;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-avatar i {
                font-size: 2.5rem;
            }

            .profile-header h2 {
                font-size: 1.5rem;
            }

            .profile-body {
                padding: 20px;
            }

            .profile-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-cancel,
            .btn-save {
                width: 100%;
                justify-content: center;
                margin: 0;
            }

            .btn-cancel {
                margin-bottom: 10px;
            }

            .edit-avatar-btn {
                top: 15px;
                right: 15px;
                width: 32px;
                height: 32px;
            }
        }

        @media (max-width: 576px) {
            .profile-container {
                padding: 15px;
            }

            .profile-header {
                padding: 25px 15px;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
            }

            .profile-avatar i {
                font-size: 2rem;
            }

            .profile-header h2 {
                font-size: 1.3rem;
            }

            .profile-body {
                padding: 15px;
            }

            .profile-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .form-group label {
                font-size: 0.8rem;
            }

            .form-control {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .btn-save,
            .btn-cancel {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-card {
            animation: fadeIn 0.4s ease forwards;
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

        /* Validation Styles */
        .form-control.is-invalid {
            border-color: var(--danger);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23dc3545' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cline x1='12' y1='8' x2='12' y2='12'%3E%3C/line%3E%3Cline x1='12' y1='16' x2='12.01' y2='16'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
            padding-right: 45px;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        .form-control.is-valid {
            border-color: var(--success);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2328a745' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
            padding-right: 45px;
        }

        .valid-feedback {
            color: var(--success);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    @if ($member->photo)
                        <img src="{{ asset('admin/uploads/' . $member->photo) }}" alt="{{ $member->name }}">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <h2>{{ $user->name }}</h2>
                <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
            </div>

            <div class="profile-body">
                <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ $user->adress ?? '' }}</textarea>
                    </div>

                    @if ($member)
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> Member Code</label>
                            <input type="text" class="form-control" value="{{ $member->code ?? 'N/A' }}" readonly>
                        </div>
                    @endif

                    <div class="form-group">
                        <label><i class="fas fa-camera"></i> Profile Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <small style="color: var(--gray-light);">Leave empty to keep current photo</small>
                    </div>

                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i>
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
