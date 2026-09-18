{{-- resources/views/equipment/show.blade.php --}}
@extends('layouts.home')

@section('title', $equipment->name . ' - Equipment Details')

@section('css')
    <style>
        /* Details Container - Light Theme */
        .details-container {
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

        .btn-edit {
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

        .btn-edit:hover {
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

        .btn-danger {
            background: var(--danger);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.2);
        }

        .btn-danger:hover {
            background: #bd2130;
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Equipment Main - Light Theme */
        .equipment-main {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Image Card - Light Theme */
        .image-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .equipment-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            background: #f5f5f5;
        }

        /* Status Badge Large - Light Theme */
        .status-badge-large {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            text-align: center;
        }

        .status-badge-large.available {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge-large.in-use {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.3);
        }

        .status-badge-large.maintenance {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-badge-large.broken {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .status-badge-large.retired {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray);
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* Info Card - Light Theme */
        .info-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .info-card h3 {
            color: var(--dark);
            margin-bottom: 20px;
        }

        /* Info Grid - Light Theme */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .info-item {
            padding: 15px;
            background: #fafafa;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .info-item:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .info-item .label {
            color: var(--gray);
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .info-item .value {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .info-item .value i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* Tabs - Light Theme */
        .tabs {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .tab-header {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background: #fafafa;
        }

        .tab-btn {
            padding: 15px 25px;
            background: transparent;
            border: none;
            color: var(--gray);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
        }

        .tab-btn:hover {
            color: var(--dark);
            background: var(--primary-light);
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            background: rgba(255, 85, 0, 0.05);
        }

        /* Tab Panes */
        .tab-pane {
            display: none;
            padding: 25px;
        }

        .tab-pane.active {
            display: block;
        }

        /* Tables - Light Theme */
        .maintenance-table,
        .assignments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .maintenance-table th,
        .assignments-table th {
            text-align: left;
            padding: 12px;
            color: var(--gray);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
        }

        .maintenance-table td,
        .assignments-table td {
            padding: 12px;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
        }

        .maintenance-table tbody tr:hover,
        .assignments-table tbody tr:hover {
            background: var(--primary-light);
        }

        .maintenance-table tbody tr:last-child td,
        .assignments-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges - Light Theme */
        .badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge.completed {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .badge.scheduled {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .badge.in-progress {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.2);
        }

        /* Assignee Info - Light Theme */
        .assignee-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .assignee-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .assignee-avatar i {
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* Overdue - Light Theme */
        .overdue {
            color: var(--danger);
            font-weight: 600;
        }

        /* Action Buttons - Light Theme */
        .action-buttons {
            display: flex;
            gap: 10px;
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

        /* ADDED: Empty State in Tabs */
        .empty-state {
            text-align: center;
            padding: 60px;
            color: var(--gray);
            background: #fafafa;
            border-radius: var(--border-radius);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
        }

        /* ADDED: Loading State */
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

        /* Responsive */
        @media (max-width: 992px) {
            .details-container {
                padding: 20px;
            }

            .equipment-main {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .details-container {
                padding: 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .tab-header {
                flex-wrap: wrap;
            }

            .tab-btn {
                flex: 1;
                text-align: center;
                padding: 12px;
                font-size: 0.85rem;
            }

            .tab-pane {
                padding: 15px;
            }

            .maintenance-table,
            .assignments-table {
                display: block;
                overflow-x: auto;
            }

            .maintenance-table th,
            .maintenance-table td,
            .assignments-table th,
            .assignments-table td {
                padding: 8px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .page-header h1 {
                font-size: 1.5rem;
            }

            .btn-edit,
            .btn-secondary,
            .btn-danger {
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .info-item .value {
                font-size: 0.95rem;
            }

            .tab-btn {
                padding: 10px;
                font-size: 0.75rem;
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

        .image-card,
        .info-card,
        .tabs {
            animation: fadeIn 0.3s ease forwards;
        }
    </style>
@endsection

@section('content')
    <div class="details-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-tools"></i>
                {{ $equipment->name }}
            </h1>
            <div class="header-actions">
                @if ($equipment->available_quantity > 0 && $equipment->status == 'available')
                    <a href="{{ route('equipment.assign.form', $equipment->id) }}" class="btn-secondary">
                        <i class="fas fa-hand-holding"></i>
                        Assign
                    </a>
                @endif
                <a href="{{ route('equipment.maintenance.form', $equipment->id) }}" class="btn-secondary">
                    <i class="fas fa-wrench"></i>
                    Maintenance
                </a>
                <a href="{{ route('equipment.edit', $equipment->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST" style="display: inline;"
                    onsubmit="return confirm('Are you sure you want to delete this equipment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="equipment-main">
            <!-- Image Card -->
            <div class="image-card">
                @if ($equipment->image)
                    <img src="{{ asset($equipment->image) }}" alt="{{ $equipment->name }}" class="equipment-image">
                @else
                    <div class="equipment-image"
                        style="display: flex; align-items: center; justify-content: center; background: var(--dark-light);">
                        <i class="fas fa-tools" style="font-size: 5rem; color: var(--gray);"></i>
                    </div>
                @endif

                <span class="status-badge-large {{ $equipment->status_color }}">
                    <i
                        class="fas {{ $equipment->status == 'available' ? 'fa-check-circle' : ($equipment->status == 'maintenance' ? 'fa-tools' : 'fa-info-circle') }}"></i>
                    {{ $equipment->status_label }}
                </span>

                <div style="margin-top: 20px; text-align: center;">
                    <div style="color: var(--gray-light);">Equipment Code</div>
                    <div style="color: white; font-size: 1.2rem; font-weight: 600;">{{ $equipment->code }}</div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="info-card">
                <h3 style="color: white; margin-bottom: 20px;">Equipment Information</h3>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="label">Category</div>
                        <div class="value"><i class="fas fa-folder"></i> {{ $equipment->category->name ?? 'N/A' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="label">Brand</div>
                        <div class="value"><i class="fas fa-industry"></i> {{ $equipment->brand ?? 'N/A' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="label">Model</div>
                        <div class="value"><i class="fas fa-cube"></i> {{ $equipment->model ?? 'N/A' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="label">Serial Number</div>
                        <div class="value"><i class="fas fa-fingerprint"></i> {{ $equipment->serial_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="label">Location</div>
                        <div class="value"><i class="fas fa-map-marker-alt"></i> {{ $equipment->location ?? 'Not set' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="label">Quantity</div>
                        <div class="value">
                            <i class="fas fa-cubes"></i>
                            {{ $equipment->available_quantity }} / {{ $equipment->quantity }} available
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <h4 style="color: white; margin-bottom: 15px;">Purchase Information</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="label">Purchase Date</div>
                            <div class="value"><i class="fas fa-calendar"></i>
                                {{ $equipment->purchase_date ? $equipment->purchase_date->format('M d, Y') : 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="label">Purchase Price</div>
                            <div class="value"><i class="fas fa-dollar-sign"></i>
                                {{ $equipment->purchase_price ? number_format($equipment->purchase_price, 2) : 'N/A' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="label">Current Value</div>
                            <div class="value"><i class="fas fa-chart-line"></i>
                                {{ $equipment->current_value ? number_format($equipment->current_value, 2) : 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="label">Supplier</div>
                            <div class="value"><i class="fas fa-truck"></i> {{ $equipment->supplier ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="label">Warranty Until</div>
                            <div class="value"><i class="fas fa-shield-alt"></i>
                                {{ $equipment->warranty_until ? \Carbon\Carbon::parse($equipment->warranty_until)->format('M d, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                @if ($equipment->description)
                    <div style="margin-top: 30px;">
                        <h4 style="color: white; margin-bottom: 15px;">Description</h4>
                        <p style="color: var(--gray-light);">{{ $equipment->description }}</p>
                    </div>
                @endif

                @if ($equipment->notes)
                    <div style="margin-top: 30px;">
                        <h4 style="color: white; margin-bottom: 15px;">Additional Notes</h4>
                        <p style="color: var(--gray-light);">{{ $equipment->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabs for Maintenance and Assignments -->
        <div class="tabs">
            <div class="tab-header">
                <button class="tab-btn active" onclick="showTab('maintenance')">
                    <i class="fas fa-wrench"></i> Maintenance History
                </button>
                <button class="tab-btn" onclick="showTab('assignments')">
                    <i class="fas fa-hand-holding"></i> Current Assignments
                </button>
            </div>

            <!-- Maintenance Tab -->
            <div id="maintenance" class="tab-pane active">
                @if ($maintenanceHistory->count() > 0)
                    <table class="maintenance-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Performed By</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maintenanceHistory as $maintenance)
                                <tr>
                                    <td>{{ $maintenance->maintenance_date->format('M d, Y') }}</td>
                                    <td>{{ ucfirst($maintenance->type) }}</td>
                                    <td>{{ Str::limit($maintenance->description, 30) }}</td>
                                    <td>{{ $maintenance->performed_by ?? 'N/A' }}</td>
                                    <td>${{ number_format($maintenance->cost ?? 0, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $maintenance->status }}">
                                            {{ ucfirst($maintenance->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-icon" onclick="viewMaintenance({{ $maintenance->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="margin-top: 20px;">
                        {{ $maintenanceHistory->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 40px; color: var(--gray-light);">
                        <i class="fas fa-wrench" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <p>No maintenance records found.</p>
                        <a href="{{ route('equipment.maintenance.form', $equipment->id) }}" class="btn-secondary"
                            style="margin-top: 15px; display: inline-block;">
                            <i class="fas fa-plus"></i>
                            Schedule Maintenance
                        </a>
                    </div>
                @endif
            </div>

            <!-- Assignments Tab -->
            <div id="assignments" class="tab-pane">
                @if ($activeAssignments->count() > 0)
                    <table class="assignments-table">
                        <thead>
                            <tr>
                                <th>Assigned To</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Assigned At</th>
                                <th>Expected Return</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeAssignments as $assignment)
                                <tr>
                                    <td>
                                        <div class="assignee-info">
                                            <div class="assignee-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span>
                                                @if ($assignment->assignable_type == 'App\\Models\\Member')
                                                    {{ $assignment->assignable->name ?? 'Unknown' }}
                                                @else
                                                    {{ $assignment->assignable->name ?? 'Unknown' }}
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($assignment->assignable_type == 'App\\Models\\Member')
                                            Member
                                        @else
                                            Trainer
                                        @endif
                                    </td>
                                    <td>{{ $assignment->quantity }}</td>
                                    <td>{{ $assignment->assigned_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        @if ($assignment->expected_return_at)
                                            @if ($assignment->is_overdue)
                                                <span class="overdue">
                                                    {{ $assignment->expected_return_at->format('M d, Y') }}
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </span>
                                            @else
                                                {{ $assignment->expected_return_at->format('M d, Y') }}
                                            @endif
                                        @else
                                            Not set
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $assignment->is_overdue ? 'overdue' : 'active' }}">
                                            {{ $assignment->is_overdue ? 'Overdue' : 'Active' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('equipment.return', $assignment->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-icon" title="Return Equipment">
                                                <i class="fas fa-undo-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 40px; color: var(--gray-light);">
                        <i class="fas fa-hand-holding" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <p>No active assignments.</p>
                        @if ($equipment->available_quantity > 0)
                            <a href="{{ route('equipment.assign.form', $equipment->id) }}" class="btn-secondary"
                                style="margin-top: 15px; display: inline-block;">
                                <i class="fas fa-plus"></i>
                                Assign Equipment
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function showTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabId).classList.add('active');

            // Add active class to clicked button
            event.target.classList.add('active');
        }

        function viewMaintenance(id) {
            // You can implement a modal to view maintenance details
            alert('View maintenance details for ID: ' + id);
        }
    </script>
@endsection
