<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\ClassInstance;
use App\Models\MemberSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userDashboard()
    {

        $is_role = Auth::user()->role;
        $is_active = Auth::user()->status;

        if ($is_role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();
        return view('dashboard.user', compact('user'));
    }




    public function adminDashboard()
    {

        $is_role = Auth::user()->role;
        $is_active = Auth::user()->status;
        // Only admins can access this
        if ($is_role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $classes_record = MemberSchedule::where('amount_paid', '>', 0)->get();
        $user = Auth::user();
        $totalUsers = User::count();
        $newUsers = User::whereDate('created_at', today())->count();
        $Recent_registered_users = User::latest()->take(5)->get();
        $admins_count = User::where('role', 'admin')->count();
        $user_count = User::where('role', 'user')->count();
        $suspended_count = User::where('status', 'suspended')->count();
        return view(
            'dashboard.adminHome',
            [
                'user' => $user,
                'newUsers' => $newUsers,
                'totalUsers' => $totalUsers,
                'Recent_registered_users' => $Recent_registered_users,
                'admins_count' => $admins_count,
                'user_count' => $user_count,
                'suspended_count' => $suspended_count,
                'classes_record' => $classes_record
            ]
        );
    }
    /**
     * Admin - User Management
     */
    public function manageUsers()
    {

        $is_role = Auth::user()->role;
        $is_active = Auth::user()->status;
        if ($is_role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $users = \App\Models\User::paginate(20);
        return view('admin.users.index', compact('users'));
    }
}
