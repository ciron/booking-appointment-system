<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{

    public function register(Request $request)
    {



        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:doctors,email',
                'password' => 'required|string|min:6',  // Add password confirmation
                'specialization' => 'required|string|max:255',
            ]);
            DB::beginTransaction();

            $validatedData['password'] = Hash::make($validatedData['password']);


            $doctor = Doctor::create($validatedData);

            $token = $doctor->createToken('doctor-auth-token')->accessToken;

            DB::commit();
            return response()->json([
                'message' => 'Doctor registered successfully',
                'doctor' => $doctor,
                'token' => $token,
            ], 201); // 201 status code for resource creation
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred during registration.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function login(Request $request)
    {
        if (Auth::guard('doctor')->check()) {
            $doctor = Auth::guard('doctor')->user();
            return response()->json([
                'message' => 'You are already logged in.',
                'doctor' => $doctor,
            ]);
        }


        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);



        $doctor = Doctor::where('email', $credentials['email'])->first();

        if ($doctor && Hash::check($credentials['password'], $doctor->password)) {
            // Generate the authentication token
            $token = $doctor->createToken('doctor-auth-token')->accessToken;

            // Return success response with token
            return response()->json([
                'message' => 'Login successful',
                'doctor' => $doctor,
                'token' => $token,
            ]);
        }

        throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
    }
}
