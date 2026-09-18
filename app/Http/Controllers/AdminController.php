<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Schedule;
use App\Models\ClassInstance;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function monitor()
    {
        // User statistics
        $totalUsers = User::count();
        $newUsersToday = User::whereDate('created_at', today())->count();
        $adminsCount = User::where('role', 'admin')->count();
        $activeUsers = User::where('status', 'active')->count();
        $suspendedUsers = User::where('status', 'suspended')->count();

        // Member statistics
        $totalMembers = Member::where('status', 'active')->count();
        $newMembersToday = Member::whereDate('created_at', today())->count();
        $expiringMembers = Member::whereHas('schedule', function ($q) {
            $q->where('member_schedule.expiry_date', '<=', now()->addDays(7))
                ->where('member_schedule.expiry_date', '>=', now());
        })->count();

        // Trainer statistics
        $totalTrainers = Trainer::where('status', 1)->count();
        $activeTrainers = Trainer::has('schedules')->count();

        // Class statistics
        $todayClasses = ClassInstance::whereDate('start_date', today())->count();
        $weekClasses = ClassInstance::whereBetween('start_date', [today(), today()->addDays(7)])->count();
        $totalAttendance = DB::table('class_instance_member')
            ->whereDate('created_at', today())
            ->count();

        // Equipment statistics
        $totalEquipment = Equipment::count();
        $equipmentInUse = Equipment::where('status', 'in_use')->count();
        $equipmentMaintenance = Equipment::whereIn('status', ['maintenance', 'broken'])->count();

        // Recent registered users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($user) {
                $user->photo_url = $user->photo
                    ? asset('admin/uploads/' . $user->photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ff5500&color=fff';
                return $user;
            });

        // Recent members
        $recentMembers = Member::with('schedule')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($member) {
                $member->photo_url = $member->photo
                    ? asset('admin/uploads/' . $member->photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=28a745&color=fff';
                return $member;
            });

        // Today's classes with attendance
        $todaysClasses = ClassInstance::with(['course', 'trainer', 'member'])
            ->whereDate('start_date', today())
            ->orderBy('start_time')
            ->limit(5)
            ->get()
            ->map(function ($class) {
                $class->enrolled = $class->member->count();
                $class->present = $class->member->whereIn('pivot.attendance_status', ['present', 'late'])->count();
                return $class;
            });

        // System health checks
        $classes = ClassInstance::whereDate('start_date', today())
            ->withCount('member')
            ->get();

        $classesWithLowAttendance = $classes->filter(function ($class) {
            return $class->members_count < ($class->total_spots * 0.3);
        })->count();
        $systemHealth = [
            'pending_maintenance' => Equipment::where('needs_maintenance', true)->count(),
            'classes_with_low_attendance' => $classesWithLowAttendance,
            'expiring_this_week' => $expiringMembers,
        ];

        // Recent activities (audit log)
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsersToday',
            'adminsCount',
            'activeUsers',
            'suspendedUsers',
            'totalMembers',
            'newMembersToday',
            'totalTrainers',
            'activeTrainers',
            'todayClasses',
            'weekClasses',
            'totalAttendance',
            'totalEquipment',
            'equipmentInUse',
            'equipmentMaintenance',
            'recentUsers',
            'recentMembers',
            'todaysClasses',
            'systemHealth',
            'recentActivities'
        ));
    }

    /**
     * User management index
     */
    public function usersIndex(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Add photo URLs
        foreach ($users as $user) {
            $user->photo_url = $user->photo
                ? asset('admin/uploads/' . $user->photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ff5500&color=fff';
        }

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'active' => User::where('status', 'active')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Create new user form
     */
    public function usersCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,suspended',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('password_confirmation', 'photo');
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('admin/uploads'), $filename);
            $data['photo'] = $filename;
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Edit user form
     */
    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        $user->photo_url = $user->photo
            ? asset('admin/uploads/' . $user->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ff5500&color=fff';

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,suspended',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('password_confirmation', 'photo');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo && file_exists(public_path('admin/uploads/' . $user->photo))) {
                unlink(public_path('admin/uploads/' . $user->photo));
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('admin/uploads'), $filename);
            $data['photo'] = $filename;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        // Don't allow deleting yourself
        if ($user->id == Auth::id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account');
        }

        // Delete photo
        if ($user->photo && file_exists(public_path('admin/uploads/' . $user->photo))) {
            unlink(public_path('admin/uploads/' . $user->photo));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Toggle user status
     */
    public function usersToggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::id()) {
            return redirect()->back()
                ->with('error', 'You cannot change your own status');
        }

        $user->status = $user->status == 'active' ? 'suspended' : 'active';
        $user->save();

        return redirect()->back()
            ->with('success', "User {$user->status} successfully");
    }

    /**
     * System settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update settings
     */
    public function settingsUpdate(Request $request)
    {
        // Implement settings update logic
        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully');
    }

    /**
     * Get recent activities (simplified audit log)
     */
    private function getRecentActivities()
    {
        $activities = [];

        // Recent user registrations
        $recentUsers = User::whereDate('created_at', '>=', now()->subDays(3))
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user_registered',
                'description' => "New user registered: {$user->name}",
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'user-plus',
                'color' => 'success',
            ];
        }

        // Recent class instances
        $recentClasses = ClassInstance::whereDate('created_at', '>=', now()->subDays(1))
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentClasses as $class) {
            $activities[] = [
                'type' => 'class_created',
                'description' => "New class scheduled: {$class->course->name}",
                'time' => $class->created_at->diffForHumans(),
                'icon' => 'calendar-plus',
                'color' => 'primary',
            ];
        }

        // Sort by time
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 8);
    }


    /**
     * Show inactive users list
     */
    public function inactiveUsers()
    {
        $inactiveUsers = User::where('status', 'inactive')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Add photo URLs
        foreach ($inactiveUsers as $user) {
            $user->photo_url = $user->photo
                ? asset('admin/uploads/' . $user->photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ff5500&color=fff';
        }

        $stats = [
            'total_inactive' => User::where('status', 'inactive')->count(),
            'total_users' => User::count(),
            'inactive_percentage' => User::count() > 0
                ? round((User::where('status', 'inactive')->count() / User::count()) * 100, 2)
                : 0,
        ];

        return view('admin.inactive_users', compact('inactiveUsers', 'stats'));
    }

    /**
     * Activate a user
     */
    public function activateUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Don't allow activating yourself if you're inactive
            if ($user->id == Auth::id()) {
                return redirect()->back()->with('error', 'You cannot activate your own account through this action.');
            }

            $user->status = 'active';
            $user->save();

            // If the user is a member, also update the member status if exists
            if ($user->role == 'member') {
                $member = Member::where('email', $user->email)->first();
                if ($member) {
                    $member->status = 'active';
                    $member->save();
                }
            }

            // If the user is a trainer, also update the trainer status if exists
            if ($user->role == 'trainer') {
                $trainer = Trainer::where('user_id', $user->id)->first();
                if ($trainer) {
                    $trainer->status = 1;
                    $trainer->save();
                }
            }

            return redirect()->route('admin.inactive.users')
                ->with('success', "User '{$user->name}' has been activated successfully.");
        } catch (\Exception $e) {
            Log::error('User activation error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error activating user: ' . $e->getMessage());
        }
    }
}
