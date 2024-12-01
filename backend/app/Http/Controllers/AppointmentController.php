<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentNotification;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    private function sendEmailNotification($appointment, $message)
    {
        try {
            $patient = Patient::find($appointment->patient_id);
            Mail::to($patient->email)->send(new AppointmentNotification($patient, $message));
        } catch (\Exception $e) {

            \Log::error('Failed to send email: ' . $e->getMessage());
        }
    }

    public function cancelAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'cancelled';
            $appointment->save();

            $this->sendEmailNotification($appointment, 'Appointment cancelled');

            return response()->json($appointment);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while cancelling the appointment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function confirmAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'confirmed';
            $appointment->save();

            $this->sendEmailNotification($appointment, 'Appointment confirmed');

            return response()->json($appointment);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while confirming the appointment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bookAppointment(Request $request)
    {

        try {

            $request->validate([
                'timeslot' => 'required',
                'appointment_date' => 'required',
                'doctor_id' => 'required|exists:doctors,id',
            ]);

            $appointment = Appointment::create([
                'patient_id' => Auth::guard('patient')->user()->id,
                'doctor_id' => $request->doctor_id,
                'timeslot' => $request->timeslot,
                'appointment_date' =>Carbon::parse($request->appointment_date)->format('Y-m-d'),
            ]);

            $this->sendEmailNotification($appointment, 'Appointment booked');

            return response()->json($appointment, 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while booking the appointment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
