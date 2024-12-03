<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentNotification extends Notification
{
    use Queueable;
    protected $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail']; // You can add other channels like 'database', 'sms', etc.
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appointment Notification')
            ->greeting('Hello, ' . $notifiable->name)
            ->line($this->message)
            ->line('Thank you for using our service!')
            ->salutation('Best regards, The Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

}
