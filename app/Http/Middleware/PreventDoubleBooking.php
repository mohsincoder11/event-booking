<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Booking;

class PreventDoubleBooking
{
    /**
     * Prevent a user from booking the same ticket more than once.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $ticket_id = $request->route('id') ?? $request->route('ticket_id');

        $existingBooking = Booking::where('user_id', $user->id)
            ->where('ticket_id', $ticket_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already booked this ticket.'
            ], 409); // 409 Conflict
        }

        return $next($request);
    }
}
