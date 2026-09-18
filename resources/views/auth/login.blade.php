<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yangzhou Gym | Login</title>

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
            --shadow-hover: 0 15px 40px rgba(255, 85, 0, 0.3);
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background */
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

        .login-container {
            width: 100%;
            max-width: 1000px;
            background: var(--secondary-light);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            display: flex;
            overflow: hidden;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }

        /* Left side - Branding */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, #ff3300 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand-logo {
            margin-bottom: 40px;
            position: relative;
        }

        .brand-logo h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 2.5rem;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .brand-logo span {
            font-family: 'Open Sans', sans-serif;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo i {
            font-size: 1.5rem;
            opacity: 0.9;
        }

        .brand-features {
            margin-top: 40px;
            position: relative;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            color: white;
        }

        .feature-item i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .feature-text h4 {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .feature-text p {
            opacity: 0.8;
            font-size: 0.9rem;
            margin: 0;
        }

        .brand-footer {
            margin-top: auto;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Right side - Login Form */
        .login-form {
            flex: 1;
            padding: 60px 50px;
            background: var(--secondary-light);
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-family: 'Montserrat', sans-serif;
            color: white;
            font-size: 2rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-header h2 i {
            color: var(--primary);
        }

        .form-header p {
            color: var(--gray-light);
            font-size: 0.95rem;
        }

        /* ADDED: Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.15);
            border: 1px solid var(--warning);
            color: var(--warning);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .alert i {
            font-size: 1.2rem;
        }

        .alert .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.7;
            transition: var(--transition);
        }

        .alert .close-btn:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #ddd;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 8px;
            width: 20px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1rem;
            z-index: 1;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background: var(--dark-light);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: var(--transition);
            font-family: 'Open Sans', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
            background: var(--dark-light);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .form-check {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check-label {
            color: var(--gray-light);
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-login i {
            font-size: 1.1rem;
        }

        .login-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .login-links a {
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .login-links a:hover {
            color: var(--primary);
        }

        .login-links a i {
            font-size: 0.85rem;
        }

        .btn-link {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--gray-light);
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            width: 100%;
            justify-content: center;
        }

        .btn-link:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }

            .login-brand {
                padding: 40px 30px;
            }

            .login-form {
                padding: 40px 30px;
            }

            .brand-features {
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .login-form {
                padding: 30px 20px;
            }

            .login-links {
                flex-direction: column;
                align-items: stretch;
            }

            .login-links a {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left side - Branding -->
        <div class="login-brand">
            <div class="brand-logo">
                <h1>Yangzhou</h1>
                <span><i class="fas fa-dumbbell"></i> GYM MANAGEMENT SYSTEM</span>
            </div>

            <div class="brand-footer">
                <p>© 2026 Yangzhou Gym. All rights reserved.</p>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div class="login-form">
            <div class="form-header">
                <h2>
                    <i class="fas fa-lock"></i>
                    Welcome Back!
                </h2>
                <p>Please login to access your dashboard</p>
            </div>

            <!-- ADDED: Alert for inactive account from session -->
            @if (session('inactive_account'))
                <div class="alert alert-warning" id="inactiveAlert">
                    <i class="fas fa-clock"></i>
                    <span>{{ session('inactive_account') }}</span>
                    <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <!-- ADDED: Alert for login error (wrong credentials) -->
            @if (session('login_error'))
                <div class="alert alert-danger" id="errorAlert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('login_error') }}</span>
                    <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <!-- Standard Laravel error display -->
            @if ($errors->any())
                <div class="alert alert-danger" id="errorAlert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $errors->first() }}</span>
                    <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email" required
                            autofocus>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-key"></i> Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-key"></i>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Enter your password" required>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        <i class="fas fa-check-circle"></i> Remember Me
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login to Dashboard
                </button>

                <div class="login-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-question-circle"></i>
                            Forgot Password?
                        </a>
                    @endif

                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Close button functionality
        document.querySelectorAll('.close-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    </script>
</body>

</html>
