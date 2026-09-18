<?php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        /*  // Check if user is authenticated
        if (!auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has the required role
        if ($role === 'admin' && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }

        if ($role === 'user' && Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized access.');
        }

        return $next($request); */


        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If roles parameter is empty, just check if authenticated
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has any of the allowed roles
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // If no matching role found, abort with 403
        abort(403, 'Unauthorized access. Required role: ' . implode(', ', $roles));
    }
}
