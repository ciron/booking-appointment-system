<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentNotification;
use App\Models\Appointment;
use App\Models\DoctorSlot;
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

            return successResponse($appointment,'Appointment confirmed Successfully!',201);
        } catch (\Exception $e) {

            return failureResponse('An error occurred while confirmed the appointment.',500,$e->getMessage());

        }
    }

    public function confirmAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'confirmed';
            $appointment->save();

            $this->sendEmailNotification($appointment, 'Appointment confirmed');

            return successResponse($appointment,'Appointment confirmed Successfully!',201);
        } catch (\Exception $e) {

            return failureResponse('An error occurred while confirmed the appointment.',500,$e->getMessage());

        }
    }

    public function bookAppointment(Request $request)
    {

        try {

            $request->validate([
                'slot_id' => 'required',
                'doctor_id' => 'required|exists:doctors,id',
            ]);

            $doctor_slot = DoctorSlot::find($request->slot_id);

            $appointment = Appointment::create([
                'patient_id' => Auth::guard('patient')->user()->id,
                'doctor_id' => $request->doctor_id,
                'doctor_slots_id' => $doctor_slot->id,
                'timeslot' => $doctor_slot->name,
                'appointment_date' =>Carbon::parse($doctor_slot->date)->format('Y-m-d'),
            ]);

            $this->sendEmailNotification($appointment, 'Appointment booked');

            return successResponse($appointment,'Appointment Created Successfully!',201);
        } catch (\Exception $e) {
            return failureResponse('An error occurred while booking the appointment.',500,$e->getMessage());

        }
    }



}
