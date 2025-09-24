<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Services\BookingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponse;

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function store(BookingRequest $request, $ticket_id)
    {
        $booking = $this->bookingService->createBooking(auth()->id(), $ticket_id, $request->quantity);
        return $this->successResponse($booking, 'Booking created successfully', 201);
    }

    public function index()
    {
        $bookings = $this->bookingService->getUserBookings(auth()->id());
        return $this->successResponse($bookings, 'Bookings fetched successfully');
    }

    public function cancel($id)
    {
        $cancelled = $this->bookingService->cancelBooking(auth()->id(), $id);
        if (!$cancelled) return $this->errorResponse('Booking not found', 404);
        return $this->successResponse(null, 'Booking cancelled successfully');
    }
}
