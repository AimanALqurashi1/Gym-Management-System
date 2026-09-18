<?php
// app/Http/Controllers/EquipmentController.php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentMaintenance;
use App\Models\EquipmentAssignment;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EquipmentController extends Controller
{
    /**
     * Display equipment dashboard
     */
    public function index(Request $request)
    {
        $query = Equipment::with(['category', 'activeAssignments']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Filter by location
        if ($request->has('location') && $request->location != 'all') {
            $query->where('location', $request->location);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $equipment = $query->orderBy('name')->paginate(15);

        $categories = EquipmentCategory::where('status', true)->get();
        $locations = Equipment::distinct()->pluck('location')->filter();

        $stats = [
            'total' => Equipment::count(),
            'available' => Equipment::where('status', 'available')->sum('available_quantity'),
            'in_use' => Equipment::where('status', 'in_use')->sum('quantity'),
            'maintenance' => Equipment::whereIn('status', ['maintenance', 'broken'])->count(),
            'needs_maintenance' => Equipment::needsMaintenance()->count(),
            'total_value' => Equipment::sum('current_value')
        ];

        return view('equipment.index', compact('equipment', 'categories', 'locations', 'stats'));
    }

    /**
     * Show equipment creation form
     */
    public function create()
    {
        $categories = EquipmentCategory::where('status', true)->get();
        $locations = ['Main Gym', 'Studio 1', 'Studio 2', 'Cardio Area', 'Weight Room', 'Storage'];

        return view('equipment.create', compact('categories', 'locations'));
    }

    /**
     * Store new equipment
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:equipment',
            'category_id' => 'required|exists:equipment_categories,id',
            'quantity' => 'required|integer|min:1',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|unique:equipment',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'current_value' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:available,in_use,maintenance,broken,retired',
            'image' => 'nullable|image|max:2048',
            'next_maintenance_date' => 'nullable|date|after:today',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except('image');
            $data['available_quantity'] = $request->quantity;
            $data['created_by'] = Auth::id();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/equipment'), $filename);
                $data['image'] = 'uploads/equipment/' . $filename;
            }

            // Generate code if not provided
            if (empty($data['code'])) {
                $data['code'] = 'EQ-' . strtoupper(Str::random(8));
            }

            $equipment = Equipment::create($data);

            DB::commit();

            return redirect()->route('equipment.show', $equipment->id)
                ->with('success', 'Equipment added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Equipment creation error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error creating equipment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show equipment details
     */
    public function show($id)
    {
        $equipment = Equipment::with(['category', 'creator', 'maintenanceRecords' => function ($q) {
            $q->latest()->limit(10);
        }, 'activeAssignments.assignable'])->findOrFail($id);

        $maintenanceHistory = $equipment->maintenanceRecords()->paginate(10);
        $activeAssignments = $equipment->activeAssignments()->with('assignable')->get();

        return view('equipment.show', compact('equipment', 'maintenanceHistory', 'activeAssignments'));
    }

    /**
     * Show equipment edit form
     */
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $categories = EquipmentCategory::where('status', true)->get();
        $locations = ['Main Gym', 'Studio 1', 'Studio 2', 'Cardio Area', 'Weight Room', 'Storage'];

        return view('equipment.edit', compact('equipment', 'categories', 'locations'));
    }

    /**
     * Update equipment
     */
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:equipment,code,' . $id,
            'category_id' => 'required|exists:equipment_categories,id',
            'quantity' => 'required|integer|min:1',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|unique:equipment,serial_number,' . $id,
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'current_value' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:available,in_use,maintenance,broken,retired',
            'image' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except('image');
            $data['updated_by'] = Auth::id();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($equipment->image && file_exists(public_path($equipment->image))) {
                    unlink(public_path($equipment->image));
                }

                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/equipment'), $filename);
                $data['image'] = 'uploads/equipment/' . $filename;
            }

            // Update availability if quantity changed
            if ($equipment->quantity != $request->quantity) {
                $diff = $request->quantity - $equipment->quantity;
                $data['available_quantity'] = $equipment->available_quantity + $diff;
            }

            $equipment->update($data);

            DB::commit();

            return redirect()->route('equipment.show', $equipment->id)
                ->with('success', 'Equipment updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Equipment update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error updating equipment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete equipment
     */
    public function destroy($id)
    {
        try {
            $equipment = Equipment::findOrFail($id);

            // Check if equipment has active assignments
            if ($equipment->activeAssignments()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Cannot delete equipment with active assignments. Please return them first.');
            }

            // Soft delete
            $equipment->delete();

            return redirect()->route('equipment.index')
                ->with('success', 'Equipment deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Equipment deletion error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error deleting equipment: ' . $e->getMessage());
        }
    }

    /**
     * Show maintenance form
     */
    public function maintenanceForm($id)
    {
        $equipment = Equipment::findOrFail($id);

        return view('equipment.maintenance', compact('equipment'));
    }

    /**
     * Schedule maintenance
     */
    public function scheduleMaintenance(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $request->validate([
            'type' => 'required|in:routine,repair,inspection,cleaning',
            'maintenance_date' => 'required|date',
            'next_maintenance_date' => 'nullable|date|after:maintenance_date',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'performed_by' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $maintenance = EquipmentMaintenance::create([
                'equipment_id' => $id,
                'type' => $request->type,
                'maintenance_date' => $request->maintenance_date,
                'next_maintenance_date' => $request->next_maintenance_date,
                'description' => $request->description,
                'notes' => $request->notes,
                'performed_by' => $request->performed_by,
                'cost' => $request->cost,
                'duration_minutes' => $request->duration_minutes,
                'status' => 'scheduled',
                'created_by' => Auth::id(),
            ]);

            // Update equipment maintenance dates
            $equipment->last_maintenance_date = $request->maintenance_date;
            $equipment->next_maintenance_date = $request->next_maintenance_date;
            $equipment->needs_maintenance = false;
            $equipment->status = 'maintenance';
            $equipment->save();

            DB::commit();

            return redirect()->route('equipment.show', $id)
                ->with('success', 'Maintenance scheduled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Maintenance scheduling error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error scheduling maintenance: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Complete maintenance
     */
    public function completeMaintenance(Request $request, $maintenanceId)
    {
        $maintenance = EquipmentMaintenance::findOrFail($maintenanceId);

        $request->validate([
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'parts_replaced' => 'nullable|json',
        ]);

        DB::beginTransaction();

        try {
            $maintenance->status = 'completed';
            $maintenance->notes = $request->notes ?? $maintenance->notes;
            $maintenance->cost = $request->cost ?? $maintenance->cost;

            if ($request->parts_replaced) {
                $maintenance->parts_replaced = json_decode($request->parts_replaced, true);
            }

            $maintenance->completed_at = now();
            $maintenance->updated_by = Auth::id();
            $maintenance->save();

            // Update equipment status back to available
            $equipment = $maintenance->equipment;
            $equipment->status = 'available';
            $equipment->needs_maintenance = false;
            $equipment->save();

            DB::commit();

            return redirect()->route('equipment.show', $equipment->id)
                ->with('success', 'Maintenance completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Maintenance completion error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error completing maintenance: ' . $e->getMessage());
        }
    }

    /**
     * Show assignment form
     */
    public function assignForm($id)
    {
        $equipment = Equipment::findOrFail($id);
        $members = Member::where('status', 'active')->orderBy('name')->get();
        $trainers = Trainer::where('status', 1)->orderBy('name')->get();

        return view('equipment.assign', compact('equipment', 'members', 'trainers'));
    }

    /**
     * Assign equipment
     */
    public function assign(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $request->validate([
            'assignable_type' => 'required|in:member,trainer',
            'assignable_id' => 'required|integer',
            'quantity' => 'required|integer|min:1|max:' . $equipment->available_quantity,
            'expected_return_at' => 'nullable|date|after:now',
            'purpose' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $assignableType = $request->assignable_type == 'member'
                ? Member::class
                : Trainer::class;

            $assignment = EquipmentAssignment::create([
                'equipment_id' => $id,
                'assignable_type' => $assignableType,
                'assignable_id' => $request->assignable_id,
                'quantity' => $request->quantity,
                'assigned_at' => now(),
                'expected_return_at' => $request->expected_return_at,
                'purpose' => $request->purpose,
                'notes' => $request->notes,
                'status' => 'assigned',
                'assigned_by' => Auth::id(),
            ]);

            // Update equipment availability
            $equipment->updateAvailability();

            DB::commit();

            return redirect()->route('equipment.show', $id)
                ->with('success', 'Equipment assigned successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Equipment assignment error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error assigning equipment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Return equipment
     */
    public function returnEquipment($assignmentId)
    {
        try {
            $assignment = EquipmentAssignment::findOrFail($assignmentId);
            $equipmentId = $assignment->equipment_id;

            $assignment->markAsReturned();

            return redirect()->route('equipment.show', $equipmentId)
                ->with('success', 'Equipment returned successfully!');
        } catch (\Exception $e) {
            Log::error('Equipment return error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error returning equipment: ' . $e->getMessage());
        }
    }

    /**
     * Equipment categories management
     */
    public function categories()
    {
        $categories = EquipmentCategory::withCount('equipment')->paginate(15);

        return view('equipment.categories', compact('categories'));
    }

    /**
     * Store equipment category
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipment_categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        try {
            EquipmentCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon,
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('equipment.categories')
                ->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            Log::error('Category creation error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update equipment category
     */
    public function updateCategory(Request $request, $id)
    {
        $category = EquipmentCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:equipment_categories,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'status' => 'boolean',
        ]);

        try {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon,
                'status' => $request->has('status'),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('equipment.categories')
                ->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            Log::error('Category update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Maintenance dashboard
     */
    public function maintenanceDashboard()
    {
        $upcomingMaintenance = EquipmentMaintenance::with('equipment')
            ->where('status', 'scheduled')
            ->whereDate('maintenance_date', '>=', now())
            ->orderBy('maintenance_date')
            ->limit(10)
            ->get();

        $overdueMaintenance = Equipment::needsMaintenance()
            ->with('category')
            ->limit(10)
            ->get();

        $recentMaintenance = EquipmentMaintenance::with('equipment')
            ->where('status', 'completed')
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'scheduled' => EquipmentMaintenance::where('status', 'scheduled')->count(),
            'in_progress' => EquipmentMaintenance::where('status', 'in_progress')->count(),
            'completed_this_month' => EquipmentMaintenance::where('status', 'completed')
                ->whereMonth('maintenance_date', now()->month)
                ->count(),
            'total_cost' => EquipmentMaintenance::where('status', 'completed')
                ->sum('cost'),
        ];

        return view('equipment.maintenance_dashboard', compact(
            'upcomingMaintenance',
            'overdueMaintenance',
            'recentMaintenance',
            'stats'
        ));
    }

    /**
     * Export equipment list
     */
    public function export(Request $request)
    {
        $query = Equipment::with('category');

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        $equipment = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="equipment_export_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($equipment) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Code',
                'Name',
                'Category',
                'Brand',
                'Model',
                'Serial Number',
                'Status',
                'Quantity',
                'Available',
                'Location',
                'Purchase Date',
                'Purchase Price',
                'Current Value',
                'Last Maintenance',
                'Next Maintenance'
            ]);

            // Data
            foreach ($equipment as $item) {
                fputcsv($file, [
                    $item->code,
                    $item->name,
                    $item->category->name ?? 'N/A',
                    $item->brand ?? 'N/A',
                    $item->model ?? 'N/A',
                    $item->serial_number ?? 'N/A',
                    $item->status_label,
                    $item->quantity,
                    $item->available_quantity,
                    $item->location ?? 'N/A',
                    $item->purchase_date ? $item->purchase_date->format('Y-m-d') : 'N/A',
                    $item->purchase_price ?? 'N/A',
                    $item->current_value ?? 'N/A',
                    $item->last_maintenance_date ? $item->last_maintenance_date->format('Y-m-d') : 'N/A',
                    $item->next_maintenance_date ? $item->next_maintenance_date->format('Y-m-d') : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
