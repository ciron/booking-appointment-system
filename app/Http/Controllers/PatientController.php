<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentNotification;
use App\Models\Appointment;
use App\Models\DoctorSlot;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PatientController extends Controller
{
    public function register(Request $request)
    {
        try {
           DB::beginTransaction();
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:patients,email',
                'password' => 'required|string|min:6',
            ]);

            $patient = Patient::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
            $token = $patient->createToken('PatientApp')->accessToken;
            $patient['token'] = $token;

            return successResponse($patient,'Registration Successfully','201');
        } catch (\Exception $e) {
          DB::rollBack();
            return failureResponse('An error occurred while registering the patient.',500,$e->getMessage());

        }
    }

    public function login(Request $request)
    {
        try {

            if (Auth::guard('patient')->check()) {
                $patient = Auth::guard('patient')->user();
                return response()->json([
                    'message' => 'You are already logged in.',
                    'doctor' => $patient,
                ]);
            }
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            $patient = Patient::where('email', $credentials['email'])->first();

            if ($patient && Hash::check($credentials['password'], $patient->password)) {

                $token = $patient->createToken('PatientApp')->accessToken;
                $patient['token'] = $token;
                return successResponse($patient,'Login Successfully','201');
            }

            return failureResponse('Invalid Credentials',401);
        } catch (\Exception $e) {

            return failureResponse('An error occurred while registering the patient.',500,$e->getMessage());
        }
    }



    public function logout(Request $request)
    {
        try {
            Auth::guard('patient')->user()->token()->revoke();
            return successResponse('Logout Successfully',500);
            } catch (\Exception $e) {

            return failureResponse('An error occurred while registering the patient.',500,$e->getMessage());
        }
    }



}
