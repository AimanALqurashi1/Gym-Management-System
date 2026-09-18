@extends('layouts.home')

@section('title', 'Membership Plans')
@section('css')
    <style>
        /* Plans Page Specific Styles - Integrated with Dashboard */
        /* Plans Page Styles - Light Theme */
        .plans-container {
            padding: 40px 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Section - Light Theme */
        .plans-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .plans-header h1 {
            font-size: 3rem;
            color: var(--dark);
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .plans-header h1 i {
            color: var(--primary);
            margin: 0 15px;
        }

        .plans-header .subtitle {
            color: var(--gray);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Plans Grid */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        /* Base Plan Card - Light Theme */
        .plan-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .plan-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary);
        }

        /* Featured Plan Card (with gradient border) - Light Theme */
        .plan-card.featured {
            background: white;
            position: relative;
            background-clip: padding-box;
            border: 2px solid transparent;
        }

        .plan-card.featured::before {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            bottom: -2px;
            left: -2px;
            background: linear-gradient(45deg,
                    var(--primary),
                    var(--accent),
                    #ff6b6b,
                    var(--primary));
            border-radius: calc(var(--border-radius) + 2px);
            z-index: -1;
            animation: gradientShift 6s ease infinite;
            background-size: 300% 300%;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Popular Badge - Light Theme */
        .popular-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
            z-index: 2;
        }

        /* Plan Icon - Light Theme */
        .plan-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-light), white);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            border: 1px solid var(--border-primary);
        }

        .plan-icon i {
            font-size: 2rem;
            color: var(--primary);
        }

        .plan-card.featured .plan-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .plan-card.featured .plan-icon i {
            color: white;
        }

        /* Plan Content - Light Theme */
        .plan-content {
            padding: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .plan-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
            font-family: 'Montserrat', sans-serif;
        }

        .plan-price {
            display: flex;
            align-items: baseline;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .plan-price .amount {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary);
            font-family: 'Montserrat', sans-serif;
        }

        .plan-price .period {
            color: var(--gray);
            margin-left: 8px;
            font-size: 0.95rem;
        }

        .plan-description {
            color: var(--gray);
            margin-bottom: 25px;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Payment Info Banner - Light Theme */
        .payment-info-banner {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px solid var(--primary);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .payment-info-text {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .payment-info-text i {
            font-size: 2rem;
            color: var(--primary);
        }

        .payment-info-text p {
            color: var(--dark);
            margin: 0;
            font-weight: 500;
        }

        .payment-info-text small {
            color: var(--gray);
            display: block;
            font-size: 0.8rem;
        }

        .payment-terms {
            background: #f5f5f5;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            color: var(--gray);
            border: 1px solid var(--border-color);
        }

        .payment-terms i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Plan Payment Note - Light Theme */
        .plan-payment-note {
            background: #f5f5f5;
            padding: 8px 12px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 0.75rem;
            color: var(--gray);
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .plan-payment-note i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Features List - Light Theme */
        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
            flex: 1;
        }

        .plan-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            color: var(--dark);
            border-bottom: 1px dashed var(--border-color);
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features li i {
            color: var(--success);
            font-size: 1rem;
            min-width: 20px;
        }

        .plan-features li i.fa-times {
            color: var(--danger);
        }

        /* Subscribe Button - Light Theme */
        .plan-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .plan-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .plan-btn:active {
            transform: translateY(0);
        }

        .plan-btn i {
            font-size: 1.1rem;
        }

        .plan-btn.btn-custom {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        }

        .plan-btn.btn-custom:hover {
            background: linear-gradient(135deg, var(--accent-dark), #0056b3);
        }

        .plan-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Empty State - Light Theme */
        .no-plans {
            grid-column: 1/-1;
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .no-plans i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-plans p {
            color: var(--gray);
            font-size: 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .plans-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .plans-container {
                padding: 20px;
            }

            .plans-header h1 {
                font-size: 2.2rem;
            }

            .plans-header h1 i {
                margin: 0 8px;
                font-size: 1.8rem;
            }

            .plans-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .plan-content {
                padding: 20px;
            }

            .plan-name {
                font-size: 1.5rem;
            }

            .plan-price .amount {
                font-size: 2rem;
            }

            .payment-info-banner {
                flex-direction: column;
                text-align: center;
            }

            .payment-info-text {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .plans-header h1 {
                font-size: 1.8rem;
            }

            .plans-header .subtitle {
                font-size: 1rem;
            }

            .popular-badge {
                padding: 5px 15px;
                font-size: 0.75rem;
            }

            .plan-features li {
                font-size: 0.85rem;
            }

            .plan-btn {
                padding: 12px;
                font-size: 0.9rem;
            }
        }

        /* Animation for cards */
        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .plan-card {
            animation: cardAppear 0.5s ease forwards;
        }

        .plan-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .plan-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .plan-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
@endsection

@section('content')
    <div class="plans-container">
        <!-- Header with modern design -->
        <div class="plans-header">
            <h1>
                <i class="fas fa-crown"></i>
                Simple, transparent pricing
                <i class="fas fa-gem"></i>
            </h1>
            <p class="subtitle">
                No hidden fees. Cancel anytime. All plans include a 14-day free trial.
            </p>
        </div>

        <!-- Plans Grid -->
        <div class="plans-grid">
            <!-- Plan 1: Basic -->
            <div class="plan-card">
                <div class="plan-content">
                    <div class="plan-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3 class="plan-name">Basic</h3>
                    <div class="plan-price">
                        <span class="amount">$1000</span>
                        <span class="period">/year</span>
                    </div>
                    <p class="plan-description">Perfect for trying out our service</p>
                    <ul class="plan-features">
                        <li>
                            <i class="fas fa-check"></i>
                            24/7 Gym Access
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Full access to all machines & equipment
                        </li>
                        <li>
                            <i class="fas fa-times"></i>
                            No trainer
                        </li>
                        <li>
                            <i class="fas fa-times"></i>
                            No classes
                        </li>
                    </ul>
                    <button class="plan-btn">
                        <i class="fas fa-rocket"></i>
                        Subscribe Now
                    </button>
                </div>
            </div>

            <!-- Plan 2: Elite - Featured -->
            <div class="plan-card featured">
                <span class="popular-badge">
                    <i class="fas fa-star"></i> Most Popular
                </span>
                <div class="plan-content">
                    <div class="plan-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3 class="plan-name">Elite</h3>
                    <div class="plan-price">
                        <span class="amount">$15000</span>
                        <span class="period">/year</span>
                    </div>
                    <p class="plan-description">For professionals and small teams</p>
                    <ul class="plan-features">
                        <li>
                            <i class="fas fa-check"></i>
                            Work with pro trainers
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Create a pro schedule
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            One-to-one classes
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Consultations from a nutritionist
                        </li>
                    </ul>
                    <button class="plan-btn">
                        <i class="fas fa-rocket"></i>
                        Subscribe Now
                    </button>
                </div>
            </div>

            <!-- Plan 3: Pro -->
            <div class="plan-card">
                <div class="plan-content">
                    <div class="plan-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="plan-name">Pro</h3>
                    <div class="plan-price">
                        <span class="amount">$10000</span>
                        <span class="period">/year</span>
                    </div>
                    <p class="plan-description">For large organizations</p>
                    <ul class="plan-features">
                        <li>
                            <i class="fas fa-check"></i>
                            Group training sessions with pro trainers
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            24/7 Gym access
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Create a pro schedule
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Priority support
                        </li>
                    </ul>
                    <button class="plan-btn">
                        <i class="fas fa-rocket"></i>
                        Subscribe Now
                    </button>
                </div>
            </div>

            <!-- Plan 4: Custom -->
            <div class="plan-card">
                <div class="plan-content">
                    <div class="plan-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <h3 class="plan-name">Custom</h3>
                    <div class="plan-price">
                        <span class="amount">$0</span>
                        <span class="period">/year</span>
                    </div>
                    <p class="plan-description">Make your plan by yourself</p>
                    <ul class="plan-features">
                        <li>
                            <i class="fas fa-check"></i>
                            Custom classes
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Custom trainers
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Custom Schedule
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Flexible pricing
                        </li>
                    </ul>
                    <button class="plan-btn btn-custom" id="custom_subscribe"
                        data-id="{{ isset($get_member) ? $get_member->id : '' }}">
                        <i class="fas fa-magic"></i>
                        Build Your Plan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Custom plan subscription
            $(document).on('click', '#custom_subscribe', function(e) {
                e.preventDefault();

                var memberId = $(this).data("id");

                if (!memberId) {
                    // Show styled notification
                    showNotification('Member ID is missing. Please log in first.', 'error');
                    return false;
                }

                // Show loading state
                var btn = $(this);
                var originalText = btn.html();
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i> Redirecting...');

                var url = '{{ route('member.MemberCourses') }}' +
                    '?member_id=' + encodeURIComponent(memberId);

                // Small delay to show loading state
                setTimeout(function() {
                    window.location.href = url;
                }, 500);
            });

            // Subscribe buttons for other plans
            $(document).on('click', '.plan-btn:not(#custom_subscribe)', function(e) {
                e.preventDefault();

                var planName = $(this).closest('.plan-card').find('.plan-name').text();

                // Show confirmation dialog
                if (confirm(`Are you sure you want to subscribe to the ${planName} plan?`)) {
                    var btn = $(this);
                    btn.prop('disabled', true);
                    btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');

                    // Simulate subscription process
                    setTimeout(function() {
                        showNotification(`Successfully subscribed to ${planName} plan!`, 'success');
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-rocket"></i> Subscribe Now');
                    }, 1500);
                }
            });

            // Notification function
            function showNotification(message, type) {
                // Create notification element
                var notification = $(`
                <div class="alert alert-${type === 'success' ? 'success' : 'danger'}" 
                     style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease;">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    ${message}
                    <button type="button" class="close" onclick="$(this).parent().remove()">&times;</button>
                </div>
            `);

                $('body').append(notification);

                // Auto remove after 3 seconds
                setTimeout(function() {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Add slide animation
            $('<style>')
                .prop('type', 'text/css')
                .html(`
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
            `)
                .appendTo('head');
        });
    </script>
@endsection
