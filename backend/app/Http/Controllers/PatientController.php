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
                $patient = Auth::guard('patient')->user();
                $token = $patient->createToken('PatientApp')->accessToken;
                return response()->json(['token' => $token,'data'=>$patient]);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while registering the patient.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetAvailableSlot(Request $request)
    {

        try {
            $request->validate([
                'timeslot' => 'required',
                'appointment_date' => 'required',
                'doctor_id' => 'required|exists:doctors,id',
            ]);

//            $appointment = DoctorSlot::where('')

//            $this->sendEmailNotification($appointment, 'Appointment booked');

//            return response()->json($appointment, 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while booking the appointment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
