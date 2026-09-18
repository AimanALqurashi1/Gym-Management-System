{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.home')

@section('title', 'Manage Users')

@section('css')
    <style>
        /* Users Container - Light Theme */
        .users-container {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
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

        /* Stats Grid - Light Theme */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        .stat-value {
            color: var(--dark);
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-label {
            color: var(--gray);
            margin-top: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Filters Section - Light Theme */
        .filters-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filters-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            display: block;
            color: var(--gray);
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group label i {
            color: var(--primary);
            margin-right: 5px;
        }

        .filter-select,
        .filter-input {
            width: 100%;
            padding: 12px 15px;
            background: var(--secondary-light);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            font-family: 'Open Sans', sans-serif;
            transition: var(--transition);
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .btn-filter {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            height: 46px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-filter:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.3);
        }

        .btn-add {
            background: var(--success);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .btn-add:hover {
            background: var(--success-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        /* Users Table - Light Theme */
        .users-table {
            width: 100%;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .users-table thead {
            background: var(--primary);
        }

        .users-table th {
            color: white;
            font-weight: 700;
            padding: 15px;
            text-align: left;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .users-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--dark);
            vertical-align: middle;
        }

        .users-table tbody tr {
            transition: var(--transition);
        }

        .users-table tbody tr:hover {
            background: var(--primary-light);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar i {
            font-size: 1.2rem;
            color: var(--primary);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
        }

        .user-email {
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Role Badges - Light Theme */
        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin {
            background: rgba(255, 85, 0, 0.15);
            color: var(--primary);
            border: 1px solid var(--border-primary);
        }

        .role-trainer {
            background: rgba(0, 168, 255, 0.15);
            color: var(--accent);
            border: 1px solid rgba(0, 168, 255, 0.2);
        }

        .role-member {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .role-staff {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        /* Status Badges - Light Theme */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.15);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-inactive {
            background: rgba(108, 117, 125, 0.15);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .status-suspended {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Action Buttons - Light Theme */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            background: transparent;
            border: none;
            color: var(--gray);
            padding: 8px;
            border-radius: 8px;
            transition: var(--transition);
            cursor: pointer;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1);
        }

        .btn-icon.edit:hover {
            background: rgba(255, 85, 0, 0.15);
            color: var(--primary);
        }

        .btn-icon.delete:hover {
            background: rgba(220, 53, 69, 0.15);
            color: var(--danger);
        }

        .btn-icon.view:hover {
            background: rgba(0, 168, 255, 0.15);
            color: var(--accent);
        }

        /* Pagination - Light Theme */
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination nav {
            display: inline-block;
        }

        .pagination ul {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
            margin: 0;
        }

        .pagination a,
        .pagination span {
            background: white;
            border: 1px solid var(--border-color);
            color: var(--dark);
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            min-width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .pagination a:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .pagination .active span {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            font-weight: 700;
        }

        .pagination .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }

        /* Empty State - Light Theme */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .users-container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .filters-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filter {
                width: 100%;
                justify-content: center;
            }

            .users-table {
                display: block;
                overflow-x: auto;
            }

            .users-table th,
            .users-table td {
                padding: 12px;
                font-size: 0.9rem;
            }

            .action-buttons {
                flex-direction: row;
            }

            .pagination a,
            .pagination span {
                padding: 6px 10px;
                min-width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .users-container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .user-cell {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons {
                justify-content: center;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .users-table,
        .filters-section {
            animation: fadeInUp 0.4s ease forwards;
        }

        /* Loading State */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="users-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-users-cog"></i>
                Manage Users
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn-add">
                <i class="fas fa-user-plus"></i>
                Add New User
            </a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--primary);">{{ $stats['admins'] }}</div>
                <div class="stat-label">Admins</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $stats['users'] }}</div>
                <div class="stat-label">Regular Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--success);">{{ $stats['active'] }}</div>
                <div class="stat-label">Active</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--danger);">{{ $stats['suspended'] }}</div>
                <div class="stat-label">Suspended</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-section">
            <form action="{{ route('admin.users.index') }}" method="GET" class="filters-form">
                <div class="filter-group">
                    <label>Search</label>
                    <input type="text" name="search" class="filter-input" placeholder="Name, email, phone..."
                        value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label>Role</label>
                    <select name="role" class="filter-select">
                        <option value="all">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-select">
                        <option value="all">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Apply Filters
                </button>

                <a href="{{ route('admin.users.index') }}" class="btn-filter" style="background: var(--gray);">
                    <i class="fas fa-undo"></i>
                    Clear
                </a>
            </form>
        </div>

        <!-- Users Table -->
        <table class="users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
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
                            <span class="badge-role {{ $user->role === 'admin' ? 'role-admin' : 'role-user' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span
                                class="status-badge {{ $user->status === 'active' ? 'status-active' : 'status-suspended' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if ($user->id != Auth::id())
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-icon"
                                            title="{{ $user->status === 'active' ? 'Suspend' : 'Activate' }}">
                                            <i
                                                class="fas {{ $user->status === 'active' ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--gray-light);">
                            <i class="fas fa-users"></i>
                            <p>No users found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection
