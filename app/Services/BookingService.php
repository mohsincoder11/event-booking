<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Ticket;
use App\Notifications\BookingConfirmedNotification;

class BookingService
{
    public function createBooking($user_id, $ticket_id, $quantity)
    {
        $ticket = Ticket::find($ticket_id);
        if (!$ticket) return null;

        if ($ticket->quantity < $quantity) {
            return null; // Not enough tickets
        }

        $booking = Booking::create([
            'user_id' => $user_id,
            'ticket_id' => $ticket_id,
            'quantity' => $quantity,
            'status' => Booking::STATUS_PENDING,
        ]);

        // Reduce available ticket quantity
        $ticket->decrement('quantity', $quantity);
        $booking->user->notify(new BookingConfirmedNotification($booking));


        return $booking;
    }

    public function getUserBookings($user_id)
    {
        return Booking::with('ticket.event')->where('user_id', $user_id)->get();
    }

    public function cancelBooking($user_id, $booking_id)
    {
        $booking = Booking::where('user_id', $user_id)->find($booking_id);
        if (!$booking) return false;

        // Refund ticket quantity
        $ticket = $booking->ticket;
        $ticket->increment('quantity', $booking->quantity);

        $booking->update(['status' => Booking::STATUS_CANCELLED]);
        return true;
    }
}
