<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoniterController extends Controller
{
    public function index()
    {
        $is_role = Auth::user()->role;
        $is_active = Auth::user()->status;
        // Only admins can access this
        if ($is_role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $user = Auth::user();
        $totalUsers = User::count();
        $newUsers = User::whereDate('created_at', today())->count();
        $Recent_registered_users = User::latest()->take(5)->get();
        $admins_count = User::where('role', 'admin')->count();
        $user_count = User::where('role', 'user')->count();
        $suspended_count = User::where('status', 'suspended')->count();
        return view(
            'admin.moniter.index',
            [
                'user' => $user,
                'newUsers' => $newUsers,
                'totalUsers' => $totalUsers,
                'Recent_registered_users' => $Recent_registered_users,
                'admins_count' => $admins_count,
                'user_count' => $user_count,
                'suspended_count' => $suspended_count
            ]
        );
    }
}
