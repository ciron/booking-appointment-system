<?php

namespace App\Http\Controllers;

use App\Notifications\AppointmentNotification;
use App\Models\Appointment;
use App\Models\DoctorSlot;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    private function sendEmailNotification($appointment, $message)
    {
        try {
            $patient = Patient::find($appointment->patient_id);
            $patient->notify(new AppointmentNotification($message));
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
            return $e->getMessage();

        }
    }

    public function cancelAppointment($id)
    {
        try {
            // Find the appointment or fail
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'cancelled';
            $appointment->save();

            // Send email notification
            $this->sendEmailNotification($appointment, 'Appointment '.$appointment->timeslot.' is  cancelled');

            return back()->with('success', 'Appointment cancelled successfully!');
        } catch (\Exception $e) {

            Log::error('Error cancelling appointment: ' . $e->getMessage());


            return back()->with('error', 'There was an error cancelling the appointment. Please try again later.');
        }
    }

    public function confirmAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'confirmed';
            $appointment->save();

            $this->sendEmailNotification($appointment, 'Appointment confirmed at '.$appointment->timeslot);
            return back()->with('success', 'Appointment confirmed successfully!');
        } catch (\Exception $e) {

            Log::error('Error cancelling appointment: ' . $e->getMessage());

            return back()->with('error', 'There was an error cancelling the appointment. Please try again later.');

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
    public function Appointments()
    {
        try {
            $appointments = Appointment::where('patient_id',Auth::guard('patient')->user()->id)->with('doctor')->latest()->get();

            return successResponse($appointments,'Appointments List Fetch Successfully!',201);
        } catch (\Exception $e) {

            return failureResponse('An error occurred while confirmed the appointment.',500,$e->getMessage());

        }
    }



}
