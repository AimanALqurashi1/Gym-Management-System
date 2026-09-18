<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Yangzhou Gym</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #ff5500;
            --primary-dark: #e04e00;
            --primary-light: rgba(255, 85, 0, 0.15);
            --secondary: #1e1e2f;
            --secondary-light: #2d2d3f;
            --dark: #151522;
            --dark-light: #1a1a2a;
            --light: #f8f9fa;
            --gray: #6c757d;
            --gray-light: #a0a0b0;
            --border-color: #2d2d3f;
            --border-primary: rgba(255, 85, 0, 0.3);
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --border-radius: 15px;
            --transition: all 0.3s ease;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, #0a0a14 100%);
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 85, 0, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 85, 0, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 25s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-30px, 30px);
            }
        }

        .register-container {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .register-card {
            background: var(--secondary-light);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .register-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 2rem;
            color: white;
            margin-bottom: 5px;
        }

        .register-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }

        .register-body {
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
            font-size: 0.9rem;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 8px;
            width: 20px;
        }

        .form-group label .required {
            color: var(--danger);
            margin-left: 3px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: var(--dark-light);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: white;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
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

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        .image-preview-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--dark-light);
            border: 3px dashed var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            overflow: hidden;
            cursor: pointer;
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

        .btn-upload {
            background: var(--primary-light);
            color: white;
            border: 1px solid var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            cursor: pointer;
            display: inline-block;
            transition: var(--transition);
        }

        .btn-upload:hover {
            background: var(--primary);
        }

        .checkbox-group {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-group label {
            color: var(--gray-light);
            cursor: pointer;
        }

        .checkbox-group a {
            color: var(--primary);
            text-decoration: none;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-register {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(255, 85, 0, 0.4);
        }

        .btn-link {
            background: transparent;
            color: white;
            border: 2px solid var(--border-color);
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
        }

        .btn-link:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .register-body {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1><i class="fas fa-dumbbell"></i> Yangzhou</h1>
                <p>Create your account to start your fitness journey</p>
            </div>

            <div class="register-body">
                @if ($errors->any())
                    <div class="alert-danger">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Image Upload -->
                    <div class="image-preview-container">
                        <div class="image-preview" id="imagePreview" onclick="document.getElementById('photo').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                        <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
                        <div class="btn-upload" onclick="document.getElementById('photo').click()">
                            <i class="fas fa-upload"></i> Upload Photo
                        </div>
                        <small style="color: var(--gray-light); display: block; margin-top: 8px;">Max size: 2MB (JPG,
                            PNG, GIF)</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Address <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Password <span class="required">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Confirm Password <span class="required">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone Number <span class="required">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                required>
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-calendar"></i> Date of Birth <span class="required">*</span></label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-venus-mars"></i> Gender <span class="required">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Register As <span class="required">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer
                                </option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-globe"></i> Nationality <span class="required">*</span></label>
                            <input type="text" name="nationality" class="form-control"
                                value="{{ old('nationality') }}" required>
                            @error('nationality')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Address <span
                                    class="required">*</span></label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-ruler"></i> Height (cm)</label>
                            <input type="number" step="0.01" name="height" class="form-control"
                                value="{{ old('height') }}" placeholder="Optional">
                            @error('height')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-weight"></i> Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control"
                                value="{{ old('weight') }}" placeholder="Optional">
                            @error('weight')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" name="terms" id="terms" required
                            {{ old('terms') ? 'checked' : '' }}>
                        <label for="terms">
                            I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy
                                Policy</a>
                        </label>
                    </div>
                    @error('terms')
                        <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                    @enderror

                    <div class="form-actions">
                        <a href="{{ route('login') }}" class="btn-link">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>
                        <button type="submit" class="btn-register">
                            <i class="fas fa-user-plus"></i> Register Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
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

        // Phone number validation (only numbers, spaces, +, -, parentheses)
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9\s\ \+\-\(\)]/g, '');
        });
    </script>
</body>

</html>
