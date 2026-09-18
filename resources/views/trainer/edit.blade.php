@extends('layouts.home')

@section('title', 'Edit Trainer - ' . $trainer->name)

@section('css')
    <style>
        .edit-container {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }

        .edit-card {
            background: var(--secondary-light);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 85, 0, 0.1));
            padding: 25px;
            border-bottom: 2px solid var(--primary);
        }

        .card-header h2 {
            color: white;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 30px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #ddd;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: var(--dark-light);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        select.form-control {
            cursor: pointer;
        }

        .image-preview-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .current-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 15px;
            border: 3px solid var(--primary);
        }

        .current-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-upload {
            background: var(--primary-light);
            color: white;
            border: 1px solid var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            display: inline-block;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid var(--border-color);
            padding: 10px 22px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="edit-container">
        <div class="edit-card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-edit"></i>
                    Edit Trainer
                </h2>
            </div>
            <div class="card-body">
                <div class="image-preview-container">
                    <div class="current-image">
                        <img src="{{ $trainer->photo_url }}" alt="{{ $trainer->name }}">
                    </div>
                    <small style="color: var(--gray-light);">Current photo</small>
                </div>

                <form action="{{ route('trainer.update', $trainer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Full Name *</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $trainer->name) }}" required>
                            @error('name')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email *</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $trainer->email) }}" required>
                            @error('email')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone *</label>
                            <input type="tel" name="phone" class="form-control"
                                value="{{ old('phone', $trainer->phone) }}" required>
                            @error('phone')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-calendar"></i> Date of Birth *</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="{{ old('date_of_birth', $trainer->date_of_birth) }}" required>
                            @error('date_of_birth')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-venus-mars"></i> Gender *</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $trainer->gender) == 'male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="female" {{ old('gender', $trainer->gender) == 'female' ? 'selected' : '' }}>
                                    Female</option>
                            </select>
                            @error('gender')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-flag"></i> Nationality *</label>
                            <input type="text" name="nationality" class="form-control"
                                value="{{ old('nationality', $trainer->nationality) }}" required>
                            @error('nationality')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-ruler"></i> Height (cm)</label>
                            <input type="number" step="0.01" name="height" class="form-control"
                                value="{{ old('height', $trainer->height) }}">
                            @error('height')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-weight"></i> Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control"
                                value="{{ old('weight', $trainer->weight) }}">
                            @error('weight')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $trainer->address) }}</textarea>
                        @error('address')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-toggle-on"></i> Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status', $trainer->status) == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ old('status', $trainer->status) == '0' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            @error('status')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-camera"></i> Profile Photo</label>
                            <input type="file" name="item_img" class="form-control" accept="image/*">
                            <small style="color: var(--gray-light);">Leave empty to keep current photo</small>
                            @error('item_img')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('trainer.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> Update Trainer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
