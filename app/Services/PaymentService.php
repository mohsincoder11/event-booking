<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;

class PaymentService
{
    public function processPayment($booking_id)
    {
        $booking = Booking::find($booking_id);
        if (!$booking) return null;

        // Mock payment logic (random success/failure)
        $status = rand(0, 1) ? Payment::STATUS_SUCCESS : Payment::STATUS_FAILED;

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->ticket->price * $booking->quantity,
            'status' => $status
        ]);

        if ($status === Payment::STATUS_SUCCESS) {
            $booking->update(['status' => Booking::STATUS_CONFIRMED]);
        }

        return $payment;
    }

    public function getPayment($id)
    {
        return Payment::with('booking.ticket.event')->find($id);
    }
}
