<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class IsPatient
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user exists in the patients table
        if (Auth::guard('patient')->check()) {
            return $next($request);
        }

        return response()->json(['message' => 'Access denied. Patients only.'], 403);
    }
}
