<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiSuperAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah ada session admin yang valid
        if (!session()->has('admin_user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin login required.',
                'error' => 'ADMIN_LOGIN_REQUIRED'
            ], 401);
        }

        // Cek apakah user adalah super admin
        $userId = session('admin_user_id');
        $user = \App\Models\User::find($userId);
        
        if (!$user || !$user->is_super_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Super admin access required.',
                'error' => 'SUPER_ADMIN_REQUIRED'
            ], 403);
        }

        return $next($request);
    }
}
