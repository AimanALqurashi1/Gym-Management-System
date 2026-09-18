{{-- resources/views/equipment/index.blade.php --}}
@extends('layouts.home')

@section('title', 'Equipment Management')

@section('css')
    <style>
        /* Equipment Container - Light Theme */
        .equipment-container {
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

        /* Header Actions - Light Theme */
        .header-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
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
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
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
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.total {
            background: rgba(255, 85, 0, 0.1);
            color: var(--primary);
        }

        .stat-icon.available {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .stat-icon.in-use {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .stat-icon.maintenance {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        .stat-icon.value {
            background: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .stat-info h3 {
            color: var(--dark);
            font-size: 1.8rem;
            margin: 0;
        }

        .stat-info p {
            color: var(--gray);
            margin: 5px 0 0;
            font-size: 0.9rem;
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
            margin-bottom: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .filter-select,
        .filter-input {
            width: 100%;
            padding: 10px 15px;
            background: #f5f5f5;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            color: var(--dark);
            font-size: 0.95rem;
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
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 42px;
            transition: var(--transition);
        }

        .btn-filter:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Equipment Grid - Light Theme */
        .equipment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        /* Equipment Card - Light Theme */
        .equipment-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .equipment-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-hover);
        }

        /* Card Header - Light Theme */
        .card-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--primary-light), white);
            border-bottom: 2px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            color: var(--dark);
            margin: 0;
            font-size: 1.2rem;
        }

        /* Status Badge - Light Theme */
        .status-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-badge.available {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-badge.in-use {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        .status-badge.maintenance {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .status-badge.broken {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .status-badge.retired {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        /* Card Body - Light Theme */
        .card-body {
            padding: 20px;
        }

        .equipment-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            background: #f5f5f5;
        }

        /* Equipment Details - Light Theme */
        .equipment-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .detail-item i {
            width: 20px;
            color: var(--primary);
        }

        .detail-item .label {
            color: var(--gray);
            min-width: 80px;
        }

        .detail-item .value {
            color: var(--dark);
            font-weight: 500;
        }

        /* Availability Bar - Light Theme */
        .availability-bar {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 8px 0;
        }

        .progress-bar {
            height: 100%;
            background: var(--success);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Maintenance Warning - Light Theme */
        .maintenance-warning {
            margin-top: 10px;
            padding: 8px 12px;
            background: rgba(255, 193, 7, 0.08);
            border-left: 3px solid var(--warning);
            border-radius: 5px;
            font-size: 0.85rem;
            color: var(--warning);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Card Footer - Light Theme */
        .card-footer {
            padding: 15px 20px;
            background: #fafafa;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-icon {
            color: var(--gray);
            background: transparent;
            border: none;
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* No Data - Light Theme */
        .no-data {
            text-align: center;
            padding: 60px 20px;
            background: #fafafa;
            border-radius: var(--border-radius);
            border: 2px dashed var(--border-color);
        }

        .no-data i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-data p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* ADDED: Pagination */
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .equipment-container {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-info h3 {
                font-size: 1.4rem;
            }

            .filters-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .equipment-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .equipment-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .card-header h3 {
                font-size: 1rem;
            }

            .detail-item {
                flex-wrap: wrap;
            }

            .detail-item .label {
                min-width: 70px;
            }

            .btn-icon {
                padding: 6px;
            }
        }

        /* Animation for cards */
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

        .equipment-card {
            animation: fadeIn 0.3s ease forwards;
        }

        .equipment-card:nth-child(1) {
            animation-delay: 0s;
        }

        .equipment-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .equipment-card:nth-child(3) {
            animation-delay: 0.1s;
        }

        .equipment-card:nth-child(4) {
            animation-delay: 0.15s;
        }

        .equipment-card:nth-child(5) {
            animation-delay: 0.2s;
        }

        .equipment-card:nth-child(6) {
            animation-delay: 0.25s;
        }

        /* Loading state */
        .loading {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }

        .loading i {
            font-size: 2rem;
            color: var(--primary);
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
    </style>
@endsection

@section('content')
    <div class="equipment-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-tools"></i>
                Equipment Management
            </h1>
            <div class="header-actions">
                <a href="{{ route('equipment.maintenance.dashboard') }}" class="btn-secondary">
                    <i class="fas fa-wrench"></i>
                    Maintenance
                </a>
                <a href="{{ route('equipment.categories') }}" class="btn-secondary">
                    <i class="fas fa-tags"></i>
                    Categories
                </a>
                <a href="{{ route('equipment.export') }}" class="btn-secondary">
                    <i class="fas fa-download"></i>
                    Export
                </a>
                <a href="{{ route('equipment.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Equipment
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Items</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon available">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['available'] }}</h3>
                    <p>Available</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon in-use">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['in_use'] }}</h3>
                    <p>In Use</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon maintenance">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['maintenance'] }}</h3>
                    <p>In Maintenance</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon value">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($stats['total_value'], 2) }}</h3>
                    <p>Total Value</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-section">
            <form action="{{ route('equipment.index') }}" method="GET" class="filters-form">
                <div class="filter-group">
                    <label>Search</label>
                    <input type="text" name="search" class="filter-input" placeholder="Name, code, brand..."
                        value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="filter-select">
                        <option value="all">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                        <option value="broken" {{ request('status') == 'broken' ? 'selected' : '' }}>Broken</option>
                        <option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>Retired</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Category</label>
                    <select name="category" class="filter-select">
                        <option value="all">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label>Location</label>
                    <select name="location" class="filter-select">
                        <option value="all">All Locations</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>

                <a href="{{ route('equipment.index') }}" class="btn-secondary" style="height: 42px;">
                    <i class="fas fa-undo"></i>
                    Clear
                </a>
            </form>
        </div>

        <!-- Equipment Grid -->
        @if ($equipment->count() > 0)
            <div class="equipment-grid">
                @foreach ($equipment as $item)
                    @php
                        $inUseCount = $item->activeAssignments->sum('quantity');
                        $availablePercent =
                            $item->quantity > 0 ? ($item->available_quantity / $item->quantity) * 100 : 0;
                    @endphp

                    <div class="equipment-card">
                        <div class="card-header">
                            <h3>{{ $item->name }}</h3>
                            <span class="status-badge {{ $item->status_color }}">
                                {{ $item->status_label }}
                            </span>
                        </div>

                        <div class="card-body">
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="equipment-image">
                            @endif

                            <div class="equipment-details">
                                <div class="detail-item">
                                    <i class="fas fa-barcode"></i>
                                    <span class="label">Code:</span>
                                    <span class="value">{{ $item->code }}</span>
                                </div>

                                <div class="detail-item">
                                    <i class="fas fa-tag"></i>
                                    <span class="label">Category:</span>
                                    <span class="value">{{ $item->category->name ?? 'N/A' }}</span>
                                </div>

                                @if ($item->brand)
                                    <div class="detail-item">
                                        <i class="fas fa-industry"></i>
                                        <span class="label">Brand:</span>
                                        <span class="value">{{ $item->brand }} {{ $item->model }}</span>
                                    </div>
                                @endif

                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="label">Location:</span>
                                    <span class="value">{{ $item->location ?? 'Not set' }}</span>
                                </div>

                                <div class="availability-bar">
                                    <div
                                        style="display: flex; justify-content: space-between; color: var(--gray-light); font-size: 0.85rem;">
                                        <span><i class="fas fa-check-circle" style="color: var(--success);"></i>
                                            Available: {{ $item->available_quantity }}</span>
                                        <span><i class="fas fa-users" style="color: #17a2b8;"></i> In Use:
                                            {{ $inUseCount }}</span>
                                        <span><i class="fas fa-box"></i> Total: {{ $item->quantity }}</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $availablePercent }}%;"></div>
                                    </div>
                                </div>

                                @if ($item->needs_maintenance)
                                    <div class="maintenance-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Maintenance required!
                                        @if ($item->next_maintenance_date)
                                            <small>Due: {{ $item->next_maintenance_date->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer">
                            <div>
                                @if ($item->available_quantity > 0 && $item->status == 'available')
                                    <a href="{{ route('equipment.assign.form', $item->id) }}" class="btn-icon"
                                        title="Assign Equipment">
                                        <i class="fas fa-hand-holding"></i>
                                    </a>
                                @endif
                                <a href="{{ route('equipment.maintenance.form', $item->id) }}" class="btn-icon"
                                    title="Schedule Maintenance">
                                    <i class="fas fa-wrench"></i>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('equipment.show', $item->id) }}" class="btn-icon"
                                    title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('equipment.edit', $item->id) }}" class="btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $equipment->links('pagination::default') }}
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-box-open"></i>
                <p>No equipment found.</p>
                <a href="{{ route('equipment.create') }}" class="btn-primary"
                    style="margin-top: 15px; display: inline-block;">
                    <i class="fas fa-plus"></i>
                    Add Your First Equipment
                </a>
            </div>
        @endif
    </div>
@endsection
