{{-- resources/views/equipment/create.blade.php --}}
@extends('layouts.home')

@section('title', 'Add New Equipment')

@section('css')
    <style>
        /* Form Container - Light Theme */
        .form-container {
            padding: 30px;
            max-width: 900px;
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
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Form Section - Light Theme */
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            color: var(--dark);
            font-size: 1.3rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        /* Form Row - Light Theme */
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
            color: var(--dark);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Form Controls - Light Theme */
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

        .form-control[readonly] {
            background: rgba(255, 85, 0, 0.05);
            border-color: var(--primary);
            cursor: not-allowed;
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

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Image Preview - Light Theme */
        .image-preview {
            width: 200px;
            height: 200px;
            background: #f5f5f5;
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
            transition: var(--transition);
        }

        .image-preview:hover {
            border-color: var(--primary);
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
            display: inline-block;
            transition: var(--transition);
        }

        .btn-upload:hover {
            background: var(--primary);
            color: white;
        }

        .file-info {
            color: var(--gray);
            font-size: 0.85rem;
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

        /* Buttons - Light Theme */
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
            box-shadow: 0 2px 4px rgba(255, 85, 0, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
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
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ADDED: Checkbox and Radio Groups */
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
        }

        /* ADDED: Select with groups */
        select optgroup {
            background: white;
            color: var(--dark);
            font-weight: 600;
        }

        select optgroup option {
            padding-left: 20px;
        }

        /* ADDED: Input with validation */
        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        .form-control.is-valid {
            border-color: var(--success);
        }

        .valid-feedback {
            color: var(--success);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        /* ADDED: Helper text */
        .form-text {
            color: var(--gray);
            font-size: 0.75rem;
            margin-top: 5px;
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

            .section-title {
                font-size: 1.1rem;
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
                width: 150px;
                height: 150px;
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

            .section-title {
                font-size: 1rem;
            }

            .form-group label {
                font-size: 0.9rem;
            }

            .form-control {
                padding: 10px 12px;
                font-size: 0.9rem;
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

        /* Loading state for submit button */
        .btn-primary.loading {
            opacity: 0.7;
            cursor: wait;
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
    </style>
@endsection

@section('content')
    <div class="form-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-plus-circle"></i>
                Add New Equipment
            </h1>
            <div class="breadcrumb">
                <a href="{{ route('equipment.index') }}">Equipment</a> /
                <span>Add New</span>
            </div>
        </div>

        <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf

            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Basic Information
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Equipment Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-barcode"></i> Equipment Code *</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}"
                            placeholder="Auto-generated if empty" required>
                        @error('code')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-folder"></i> Category *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-cubes"></i> Quantity *</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}"
                            min="1" required>
                        @error('quantity')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Brand & Model -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-industry"></i>
                    Brand & Model
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-trademark"></i> Brand</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
                        @error('brand')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-cube"></i> Model</label>
                        <input type="text" name="model" class="form-control" value="{{ old('model') }}">
                        @error('model')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-fingerprint"></i> Serial Number</label>
                        <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number') }}">
                        @error('serial_number')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Location</label>
                        <select name="location" class="form-control">
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location }}" {{ old('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                        @error('location')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Purchase Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-shopping-cart"></i>
                    Purchase Information
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Purchase Date</label>
                        <input type="date" name="purchase_date" class="form-control"
                            value="{{ old('purchase_date') }}">
                        @error('purchase_date')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-dollar-sign"></i> Purchase Price</label>
                        <input type="number" step="0.01" name="purchase_price" class="form-control"
                            value="{{ old('purchase_price') }}">
                        @error('purchase_price')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-chart-line"></i> Current Value</label>
                        <input type="number" step="0.01" name="current_value" class="form-control"
                            value="{{ old('current_value') }}">
                        @error('current_value')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-truck"></i> Supplier</label>
                        <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}">
                        @error('supplier')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-shield-alt"></i> Warranty Until</label>
                        <input type="date" name="warranty_until" class="form-control"
                            value="{{ old('warranty_until') }}">
                        @error('warranty_until')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-info-circle"></i> Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>
                                Available</option>
                            <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance
                            </option>
                            <option value="broken" {{ old('status') == 'broken' ? 'selected' : '' }}>Broken</option>
                            <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Retired</option>
                        </select>
                        @error('status')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Maintenance Schedule -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-check"></i>
                    Maintenance Schedule
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Next Maintenance Date</label>
                        <input type="date" name="next_maintenance_date" class="form-control"
                            value="{{ old('next_maintenance_date') }}">
                        @error('next_maintenance_date')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-sticky-note"></i> Notes</label>
                        <input type="text" name="notes" class="form-control" value="{{ old('notes') }}">
                        @error('notes')
                            <small style="color: var(--danger);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-image"></i>
                    Equipment Image
                </h3>

                <div class="form-group">
                    <div class="image-preview" id="imagePreview">
                        <i class="fas fa-camera"></i>
                    </div>
                    <label for="image" class="btn-upload">
                        <i class="fas fa-upload"></i> Choose Image
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" style="display: none;">
                    <div class="file-info">Max file size: 2MB. Allowed: JPG, PNG, GIF</div>
                    @error('image')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('equipment.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i>
                    Save Equipment
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
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
