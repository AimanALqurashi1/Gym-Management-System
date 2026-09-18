<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yangzhou Gym | Transform Your Body, Transform Your Life</title>

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
            background: var(--dark);
            color: white;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: var(--transition);
            background: rgba(21, 21, 34, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar.scrolled {
            padding: 15px 50px;
            background: rgba(21, 21, 34, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: var(--primary);
        }

        .logo i {
            color: var(--primary);
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            font-size: 1rem;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .btn-login {
            background: transparent;
            border: 2px solid var(--primary);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-register {
            background: var(--primary);
            border: 2px solid var(--primary);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-register:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 100px 50px;
            background: linear-gradient(135deg, var(--dark) 0%, #0a0a14 100%);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(255, 85, 0, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
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

        .hero-content {
            flex: 1;
            position: relative;
            z-index: 10;
            max-width: 600px;
        }

        .hero-badge {
            background: var(--primary-light);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid var(--border-primary);
        }

        .hero-content h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 4rem;
            line-height: 1.2;
            margin-bottom: 20px;
            color: white;
        }

        .hero-content h1 span {
            color: var(--primary);
            display: block;
        }

        .hero-content p {
            color: var(--gray-light);
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-item p {
            color: var(--gray-light);
            font-size: 0.95rem;
            margin: 0;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: white;
            padding: 13px 33px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-outline:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .hero-image {
            flex: 1;
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image img {
            max-width: 100%;
            animation: floatImage 6s ease-in-out infinite;
        }

        @keyframes floatImage {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Featured Trainers Section */
        .trainers-section {
            padding: 100px 50px;
            background: var(--secondary-light);
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 60px;
        }

        .section-header h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
            color: white;
            margin-bottom: 20px;
        }

        .section-header h2 span {
            color: var(--primary);
        }

        .section-header p {
            color: var(--gray-light);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .trainers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .trainer-card {
            background: var(--dark-light);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
        }

        .trainer-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .trainer-image {
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .trainer-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .trainer-card:hover .trainer-image img {
            transform: scale(1.1);
        }

        .trainer-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            display: flex;
            align-items: flex-end;
            padding: 20px;
            opacity: 0;
            transition: var(--transition);
        }

        .trainer-card:hover .trainer-overlay {
            opacity: 1;
        }

        .trainer-social {
            display: flex;
            gap: 15px;
        }

        .trainer-social a {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .trainer-social a:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }

        .trainer-info {
            padding: 25px;
        }

        .trainer-info h3 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .trainer-info .specialty {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
            display: block;
        }

        .trainer-info p {
            color: var(--gray-light);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .trainer-stats {
            display: flex;
            gap: 20px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
        }

        .trainer-stats span {
            color: var(--gray-light);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trainer-stats i {
            color: var(--primary);
        }

        /* Classes Section */
        .classes-section {
            padding: 100px 50px;
            background: var(--dark);
        }

        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .class-card {
            background: var(--secondary-light);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .class-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .class-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .class-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .class-card:hover .class-image img {
            transform: scale(1.1);
        }

        .class-tag {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .class-info {
            padding: 25px;
        }

        .class-info h3 {
            color: white;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .class-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .class-meta span {
            color: var(--gray-light);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .class-meta i {
            color: var(--primary);
        }

        .class-info p {
            color: var(--gray-light);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .class-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .class-price {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 700;
        }

        .class-price small {
            font-size: 0.9rem;
            color: var(--gray-light);
            font-weight: normal;
        }

        .btn-class {
            background: transparent;
            border: 2px solid var(--primary);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-class:hover {
            background: var(--primary);
        }

        /* Facilities Section */
        .facilities-section {
            padding: 100px 50px;
            background: var(--secondary-light);
        }

        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .facility-card {
            text-align: center;
            padding: 40px 30px;
            background: var(--dark-light);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .facility-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .facility-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--primary);
            border: 2px solid var(--border-primary);
        }

        .facility-card h3 {
            color: white;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .facility-card p {
            color: var(--gray-light);
            line-height: 1.6;
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 50px;
            background: var(--dark);
        }

        .testimonials-slider {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .testimonial-card {
            background: var(--secondary-light);
            border-radius: var(--border-radius);
            padding: 40px;
            border: 1px solid var(--border-color);
            margin: 20px;
            position: relative;
        }

        .testimonial-quote {
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.3;
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .testimonial-content {
            margin-bottom: 30px;
        }

        .testimonial-content p {
            color: white;
            font-size: 1.1rem;
            line-height: 1.8;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary);
        }

        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            color: white;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .author-info p {
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 50px;
            background: linear-gradient(135deg, var(--primary) 0%, #ff3300 100%);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .cta-content {
            position: relative;
            z-index: 10;
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-content h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
            color: white;
            margin-bottom: 20px;
        }

        .cta-content p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn-cta-primary {
            background: white;
            color: var(--primary);
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-cta-primary:hover {
            background: var(--dark);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-cta-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 13px 33px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-cta-outline:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Footer */
        .footer {
            background: var(--dark-light);
            padding: 60px 50px 20px;
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .footer-col h3 {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-col h3 i {
            color: var(--primary);
        }

        .footer-col p {
            color: var(--gray-light);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--gray-light);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: var(--primary);
            transform: translateX(5px);
        }

        .footer-links i {
            color: var(--primary);
            font-size: 0.8rem;
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            color: var(--gray-light);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-info i {
            color: var(--primary);
            width: 20px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            color: var(--gray-light);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .navbar {
                padding: 20px;
            }

            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 120px 20px 60px;
            }

            .hero-stats {
                justify-content: center;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-content h1 {
                font-size: 3rem;
            }

            .hero-content h1 span {
                display: inline;
            }
        }

        @media (max-width: 768px) {
            .hero-stats {
                flex-direction: column;
                gap: 20px;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .section-header h2 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <a href="#" class="logo">
            <i class="fas fa-dumbbell"></i>
            Yangzhou<span>Gym</span>
        </a>

        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#trainers">Trainers</a>
            <a href="#classes">Classes</a>
            <a href="#facilities">Facilities</a>
            <a href="#testimonials">Testimonials</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
            <a href="{{ route('register') }}" class="btn-register">
                <i class="fas fa-user-plus"></i>
                Register
            </a>
        </div>

        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-fire"></i> GRAND OPENING
            </div>
            <h1>
                TRANSFORM YOUR
                <span>BODY & MIND</span>
            </h1>
            <p>Join Yangzhou Gym today and experience the ultimate fitness journey with state-of-the-art equipment,
                expert trainers, and a supportive community.</p>

            <div class="hero-stats">
                <div class="stat-item">
                    <h3>10+</h3>
                    <p>Expert Trainers</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Weekly Classes</p>
                </div>
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Happy Members</p>
                </div>
            </div>

            <div class="hero-buttons">
                <a href="#classes" class="btn-primary">
                    <i class="fas fa-calendar-alt"></i>
                    View Classes
                </a>
                <a href="#contact" class="btn-outline">
                    <i class="fas fa-map-marker-alt"></i>
                    Visit Us
                </a>
            </div>
        </div>

        <div class="hero-image">
            <img src="{{ asset('admin/uploads/gym picture.jpg') }}" alt="Fitness">
        </div>
    </section>

    <!-- Featured Trainers Section -->
    <section class="trainers-section" id="trainers">
        <div class="section-header">
            <h2>MEET OUR <span>ELITE TRAINERS</span></h2>
            <p>Our certified trainers are dedicated to helping you achieve your fitness goals with personalized guidance
                and motivation.</p>
        </div>

        <div class="trainers-grid">
            {{-- @php
                // Sample trainer data - replace with your actual trainer data
                $trainers = [
                    [
                        'name' => 'John Smith',
                        'specialty' => 'Strength & Conditioning',
                        'image' =>
                            'https://images.unsplash.com/photo-1567013127542-490d757e51fc?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'experience' => '10+ years',
                        'students' => '500+',
                        'bio' =>
                            'Former professional athlete with expertise in strength training and functional fitness.',
                    ],
                    [
                        'name' => 'Sarah Johnson',
                        'specialty' => 'Yoga & Pilates',
                        'image' =>
                            'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'experience' => '8+ years',
                        'students' => '300+',
                        'bio' =>
                            'Certified yoga instructor specializing in flexibility, mindfulness, and core strength.',
                    ],
                    [
                        'name' => 'Mike Williams',
                        'specialty' => 'HIIT & Cardio',
                        'image' =>
                            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'experience' => '12+ years',
                        'students' => '800+',
                        'bio' => 'High-energy trainer focused on intense workouts that deliver maximum results.',
                    ],
                ];
            @endphp
 --}}
            @foreach ($trainers as $trainer)
                <div class="trainer-card">
                    <div class="trainer-image">
                        <img src="{{ asset('admin/uploads') . '/' . $trainer->photo }}" alt="{{ $trainer['name'] }}">
                        <div class="trainer-overlay">
                            <div class="trainer-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="trainer-info">
                        <h3>{{ $trainer['name'] }}</h3>
                        <span class="specialty">{{ $trainer['course_names_string'] }}</span>
                        <p>{{ $trainer['bio'] }}</p>
                        <div class="trainer-stats">
                            <span><i class="fas fa-clock"></i> {{ $trainer['experience'] }} Yesrs experience</span>
                            <span><i class="fas fa-users"></i> {{ $trainer['students'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Classes Section -->
    <section class="classes-section" id="classes">
        <div class="section-header">
            <h2>POPULAR <span>CLASSES</span></h2>
            <p>Choose from our wide variety of classes designed for all fitness levels</p>
        </div>

        <div class="classes-grid">
            @php
                $classes = [
                    [
                        'name' => 'Power HIIT',
                        'image' =>
                            'https://images.unsplash.com/photo-1549060279-7e168fcee0c2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'time' => 'Mon, Wed, Fri 8:00 AM',
                        'duration' => '45 min',
                        'trainer' => 'Mike Williams',
                        'level' => 'Intermediate',
                        'price' => '$120',
                        'period' => '/month',
                        'description' => 'High-intensity interval training that burns calories and builds endurance.',
                    ],
                    [
                        'name' => 'Yoga Flow',
                        'image' =>
                            'https://images.unsplash.com/photo-1545205597-3d9d02c29597?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'time' => 'Tue, Thu 6:00 PM',
                        'duration' => '60 min',
                        'trainer' => 'Sarah Johnson',
                        'level' => 'All Levels',
                        'price' => '$100',
                        'period' => '/month',
                        'description' => 'Find your inner peace with flowing sequences and mindful breathing.',
                    ],
                    [
                        'name' => 'Strength Training',
                        'image' =>
                            'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'time' => 'Mon, Wed 6:00 PM',
                        'duration' => '50 min',
                        'trainer' => 'John Smith',
                        'level' => 'Advanced',
                        'price' => '$130',
                        'period' => '/month',
                        'description' =>
                            'Build muscle and increase strength with compound lifts and progressive overload.',
                    ],
                    [
                        'name' => 'Boxing Fitness',
                        'image' =>
                            'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                        'time' => 'Tue, Thu 8:00 AM',
                        'duration' => '45 min',
                        'trainer' => 'Mike Williams',
                        'level' => 'Intermediate',
                        'price' => '$125',
                        'period' => '/month',
                        'description' => 'Punch and kick your way to fitness with this high-energy boxing workout.',
                    ],
                ];
            @endphp

            @foreach ($classes as $class)
                <div class="class-card">
                    <div class="class-image">
                        <img src="{{ $class['image'] }}" alt="{{ $class['name'] }}">
                        <span class="class-tag">{{ $class['level'] }}</span>
                    </div>
                    <div class="class-info">
                        <h3>{{ $class['name'] }}</h3>
                        <div class="class-meta">
                            <span><i class="fas fa-clock"></i> {{ $class['time'] }}</span>
                            <span><i class="fas fa-hourglass-half"></i> {{ $class['duration'] }}</span>
                        </div>
                        <div class="class-meta">
                            <span><i class="fas fa-user-tie"></i> {{ $class['trainer'] }}</span>
                        </div>
                        <p>{{ $class['description'] }}</p>
                        <div class="class-footer">
                            <div class="class-price">
                                {{ $class['price'] }}<small>{{ $class['period'] }}</small>
                            </div>
                            <a href="{{ route('register') }}" class="btn-class">
                                Join Now <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="facilities-section" id="facilities">
        <div class="section-header">
            <h2>WORLD-CLASS <span>FACILITIES</span></h2>
            <p>Experience the best equipment and amenities in a clean, motivating environment</p>
        </div>

        <div class="facilities-grid">
            <div class="facility-card">
                <div class="facility-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h3>Modern Equipment</h3>
                <p>State-of-the-art machines and free weights from top brands</p>
            </div>

            <div class="facility-card">
                <div class="facility-icon">
                    <i class="fas fa-hot-tub"></i>
                </div>
                <h3>Luxury Locker Rooms</h3>
                <p>Premium showers, sauna, and changing facilities</p>
            </div>

            <div class="facility-card">
                <div class="facility-icon">
                    <i class="fas fa-person-swimming"></i>
                </div>
                <h3>Pool & Spa</h3>
                <p>Olympic-sized pool and relaxing spa area</p>
            </div>

            <div class="facility-card">
                <div class="facility-icon">
                    <i class="fas fa-mug-hot"></i>
                </div>
                <h3>Protein Bar</h3>
                <p>Healthy shakes and snacks post-workout</p>
            </div>

            <div class="facility-card">
                <div class="facility-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3>Free WiFi</h3>
                <p>Stay connected while you work out</p>
            </div>

            <div class="facility-card">
                <div class="facility-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3>Ample Parking</h3>
                <p>Free parking for all members</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="section-header">
            <h2>WHAT OUR <span>MEMBERS SAY</span></h2>
            <p>Real results from real people</p>
        </div>

        <div class="testimonials-slider">
            <div class="testimonial-card">
                <div class="testimonial-quote">
                    <i class="fas fa-quote-right"></i>
                </div>
                <div class="testimonial-content">
                    <p>"Yangzhou completely transformed my fitness journey. The trainers are incredibly knowledgeable
                        and supportive. I've lost 30 pounds and gained so much confidence!"</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="{{ asset('admin/uploads/maleLogo.png') }}" alt="Khaled">
                    </div>
                    <div class="author-info">
                        <h4>Nasser Mitchell</h4>
                        <p>Member since 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>READY TO START YOUR JOURNEY?</h2>
            <p>Join Yangzhou Gym today and get your first week free!</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-cta-primary">
                    <i class="fas fa-user-plus"></i>
                    Join Now
                </a>
                <a href="#contact" class="btn-cta-outline">
                    <i class="fas fa-calendar-alt"></i>
                    Book a Tour
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-col">
                <h3><i class="fas fa-dumbbell"></i> Yangzhou</h3>
                <p>Your ultimate fitness destination. We provide the best equipment, expert trainers, and motivating
                    community to help you achieve your fitness goals.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h3><i class="fas fa-link"></i> QUICK LINKS</h3>
                <ul class="footer-links">
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="#trainers"><i class="fas fa-chevron-right"></i> Trainers</a></li>
                    <li><a href="#classes"><i class="fas fa-chevron-right"></i> Classes</a></li>
                    <li><a href="#facilities"><i class="fas fa-chevron-right"></i> Facilities</a></li>
                    <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Testimonials</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3><i class="fas fa-clock"></i> HOURS</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-calendar-day"></i> Monday - Friday: 5:00 AM - 11:00 PM</li>
                    <li><i class="fas fa-calendar-day"></i> Saturday: 7:00 AM - 9:00 PM</li>
                    <li><i class="fas fa-calendar-day"></i> Sunday: 8:00 AM - 8:00 PM</li>
                    <li><i class="fas fa-holiday"></i> Holidays: 8:00 AM - 6:00 PM</li>
                </ul>
            </div>

            <div class="footer-col">
                <h3><i class="fas fa-map-marker-alt"></i> CONTACT</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-map-pin"></i> Yangzijin , Yangzhou, China</li>
                    <li><i class="fas fa-phone"></i> +86 1520 527 3124</li>
                    <li><i class="fas fa-envelope"></i> Yangzhou@edu.cn</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 Gym Management System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu (you can implement this)
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            // Add your mobile menu logic here
            alert('Mobile menu would open here');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
