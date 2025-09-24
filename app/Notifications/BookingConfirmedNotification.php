<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail']; // can also add 'database' if needed
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking Confirmed')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your booking for ticket ID ' . $this->booking->ticket_id . ' has been confirmed.')
            ->line('Quantity: ' . $this->booking->quantity)
            ->line('Thank you for using our event booking system!');
    }
}
