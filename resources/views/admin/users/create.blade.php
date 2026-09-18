{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.home')

@section('title', 'Add New User')

@section('css')
    <style>
        /* Form Container - Light Theme */
        .form-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
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

        /* Form Card - Light Theme */
        .form-card {
            background: var(--light);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .form-card:hover {
            border-color: var(--border-primary);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        /* Form Row - Light Theme */
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
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
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        .required-field::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }

        /* Form Controls - Light Theme */
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
            background: var(--light);
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
            background: var(--light);
            color: var(--dark);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Image Preview - Light Theme */
        .image-preview {
            width: 150px;
            height: 150px;
            background: var(--secondary-light);
            border: 2px dashed var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }

        .image-preview:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            transform: scale(1.02);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview i {
            font-size: 3rem;
            color: var(--gray);
        }

        /* Upload Button - Light Theme */
        .btn-upload {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .btn-upload:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* File info text */
        .file-info {
            color: var(--gray);
            font-size: 0.75rem;
            margin-top: 5px;
        }

        /* Form Actions - Light Theme */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        /* Buttons - Light Theme (Matching Dashboard) */
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
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray);
            border: 2px solid var(--border-color);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: var(--transition);
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
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

        /* Helper Text */
        .form-text {
            color: var(--gray);
            font-size: 0.75rem;
            margin-top: 5px;
        }

        /* Checkbox and Radio Groups */
        .checkbox-group,
        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .checkbox-item,
        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-item input,
        .radio-item input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-item label,
        .radio-item label {
            color: var(--dark);
            cursor: pointer;
            margin: 0;
            font-weight: normal;
            text-transform: none;
        }

        /* Form Divider */
        .form-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .form-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .form-divider span {
            background: var(--light);
            padding: 0 15px;
            position: relative;
            color: var(--gray);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-card {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .image-preview {
                width: 120px;
                height: 120px;
                margin-left: auto;
                margin-right: auto;
            }

            .checkbox-group,
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 15px;
            }

            .form-card {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .form-group label {
                font-size: 0.85rem;
            }

            .form-control {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .btn-primary,
            .btn-secondary {
                padding: 10px 20px;
                font-size: 0.85rem;
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

        .form-card {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Loading state for button */
        .btn-primary.loading {
            opacity: 0.7;
            cursor: wait;
            position: relative;
        }

        .btn-primary.loading i {
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

        /* Disabled state */
        .form-control:disabled,
        .form-control[readonly] {
            background: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Tooltip for help text */
        .help-tooltip {
            color: var(--gray);
            cursor: help;
            margin-left: 5px;
            font-size: 0.8rem;
            transition: var(--transition);
        }

        .help-tooltip:hover {
            color: var(--primary);
        }

        /* Additional Dashboard Matching Styles */
        .form-card .section-title {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-primary);
            display: inline-block;
        }

        /* Alert messages within forms */
        .form-alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-alert-success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: var(--success);
        }

        .form-alert-error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: var(--danger);
        }

        .form-alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            color: var(--warning);
        }
    </style>
@endsection

@section('content')
    <div class="form-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-user-plus"></i>
                Add New User
            </h1>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email Address *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Card Number</label>
                    <input type="text" name="card_number" class="form-control" value="{{ old('card_number') }}">
                    @error('card_number')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password *</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Regular User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-toggle-on"></i> Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-map-marker-alt"></i> Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                @error('address')
                    <small style="color: var(--danger);">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label><i class="fas fa-camera"></i> Profile Photo</label>
                <div class="image-preview" id="imagePreview">
                    <i class="fas fa-user-circle"></i>
                </div>
                <label for="photo" class="btn-upload">
                    <i class="fas fa-upload"></i> Choose Photo
                </label>
                <input type="file" name="photo" id="photo" accept="image/*" style="display: none;">
                <small style="color: var(--gray-light); display: block; margin-top: 5px;">Max size: 2MB. Allowed: JPG,
                    PNG</small>
                @error('photo')
                    <small style="color: var(--danger);">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i>
                    Create User
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
