<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentNotification extends Mailable
{
    public $patient;
    public $message;

    public function __construct($patient, $message)
    {
        $this->patient = $patient;
        $this->message = $message;
    }

    public function build()
    {
        return $this->view('Email.Notification')
            ->with([
                'patient' => $this->patient,
                'message' => $this->message,
            ]);
    }
}
