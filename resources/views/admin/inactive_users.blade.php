@extends('layouts.home')

@section('title', 'Inactive Users')

@section('css')
    <style>
        .inactive-container {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: white;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header h1 i {
            color: var(--primary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
        }

        .stat-card h3 {
            color: white;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--gray-light);
            margin: 0;
        }

        .users-table {
            width: 100%;
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .users-table th {
            background: rgba(0, 0, 0, 0.3);
            color: var(--gray-light);
            font-weight: 600;
            padding: 15px;
            text-align: left;
        }

        .users-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: white;
            vertical-align: middle;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-role {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .role-admin {
            background: rgba(255, 85, 0, 0.15);
            color: var(--primary);
        }

        .role-user {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray-light);
        }

        .role-trainer {
            background: rgba(23, 162, 184, 0.15);
            color: #17a2b8;
        }

        .role-member {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
        }

        .btn-activate {
            background: var(--success);
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-activate:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .no-data {
            text-align: center;
            padding: 60px;
            color: var(--gray-light);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .users-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
@endsection

@section('content')
    <div class="inactive-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-user-slash"></i>
                Inactive Users
            </h1>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $stats['total_inactive'] }}</h3>
                <p>Inactive Users</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['inactive_percentage'] }}%</h3>
                <p>Inactive Percentage</p>
            </div>
        </div>

        <!-- Users Table -->
        <table class="users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inactiveUsers as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}">
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="badge-role role-{{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.user.activate', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to activate this user?')">
                                @csrf
                                <button type="submit" class="btn-activate">
                                    <i class="fas fa-check-circle"></i>
                                    Activate
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">
                            <i class="fas fa-user-check"></i>
                            No inactive users found. All users are active!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $inactiveUsers->links() }}
        </div>
    </div>
@endsection
