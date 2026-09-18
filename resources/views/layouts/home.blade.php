<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yangzhou Gym | Management Dashboard</title>
    <title>@yield('title')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}


    <!-- DASHBOARD CSS - Load this second (dashboard specific) -->
    <link rel="stylesheet" href="{{ asset('admin/css/dashboardStyleLightTheme.css') }}">


    {{-- <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}"> --}}

    <!-- PAGE SPECIFIC CSS - Load this last (page specific) -->




    @yield('css')
</head>

<body>
    @if (Auth::user()->role == 'admin')
        @include('includes.sidebar')
    @elseif (Auth::user()->role == 'user')
        @include('includes.user_siderbar')
    @elseif (Auth::user()->role == 'member')
        @include('includes.member_sidebar')
    @elseif (Auth::user()->role == 'trainer')
        @include('includes.trainer_sidebar')
    @endif

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div style="display: flex; align-items: center;">
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title" id="pageTitle">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </h1>
            </div>

            <div class="top-bar-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search members, classes...">
                </div>

                <!-- Notification Bell - Only for Admin and User roles -->
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'user')
                    @php
                        $inactiveUsersCount = \App\Models\User::where('status', 'inactive')->count();
                    @endphp
                    <a href="{{ route('admin.inactive.users') }}" class="notification-btn"
                        style="text-decoration: none;">
                        <i class="fas fa-bell"></i>
                        @if ($inactiveUsersCount > 0)
                            <span class="notification-badge">{{ $inactiveUsersCount }}</span>
                        @endif
                    </a>
                @endif
            </div>
        </div>

        @include('includes.alerts.success')
        @include('includes.alerts.error')

        <!-- Dashboard Content -->
        @yield('content')
    </div>

    <!-- Add Member Modal -->
    <div class="modal" id="addMemberModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-plus"></i> Add New Member</h3>
                <button class="modal-close" id="closeMemberModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="memberForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="membershipType">Membership Type</label>
                            <select id="membershipType" class="form-control" required>
                                <option value="">Select Plan</option>
                                <option value="basic">Basic Plan - $29/month</option>
                                <option value="pro">Pro Plan - $49/month</option>
                                <option value="elite">Elite Plan - $79/month</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="joinDate">Join Date</label>
                            <input type="date" id="joinDate" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-danger" id="cancelMemberBtn">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('/admin/js/dashboardScript.js') }}"></script>
    @yield('script')
</body>

</html>
