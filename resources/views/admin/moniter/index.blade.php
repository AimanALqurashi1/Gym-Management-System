@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->photo_url }}" class="img-fluid rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;" alt="Admin Photo">
                        <h5>{{ auth()->user()->name }}</h5>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <span class="badge bg-danger">Administrator</span>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">
                            Manage Users
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            Settings
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Admin Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <!-- Stats Cards -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-white bg-info mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Users</h5>
                                        <h2 class="card-text">{{ $totalUsers }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">New Today</h5>
                                        <h2 class="card-text">{{ $newUsers }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-warning mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Admins</h5>
                                        <h2 class="card-text">
                                            {{ $admins_count }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-danger mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Suspended</h5>
                                        <h2 class="card-text">
                                            {{ $suspended_count }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Quick Actions</h5>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                        <i class="bi bi-people"></i> Manage Users
                                    </a>
                                    <button class="btn btn-success">
                                        <i class="bi bi-plus-circle"></i> Add New User
                                    </button>
                                    <button class="btn btn-info">
                                        <i class="bi bi-file-earmark-text"></i> Generate Report
                                    </button>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Users Table -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Recent Registered Users</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Role</th>
                                                        <th>Status</th>
                                                        <th>Joined</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Recent_registered_users as $user)
                                                        <tr>
                                                            <td>
                                                                <img src="{{ $user->photo_url }}"
                                                                    class="rounded-circle me-2"
                                                                    style="width: 30px; height: 30px;">
                                                                {{ $user->name }}
                                                            </td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
                                                                    {{ $user->role }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                                    {{ $user->status }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-info">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
