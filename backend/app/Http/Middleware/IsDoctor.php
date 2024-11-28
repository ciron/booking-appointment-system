<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class IsDoctor
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user exists in the doctors table
        if (Auth::guard('doctor')->check()) {
            return $next($request);
        }

        return response()->json(['message' => 'Access denied. Doctors only.'], 403);
    }
}
