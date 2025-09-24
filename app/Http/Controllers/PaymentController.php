<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function process(Request $request, $booking_id)
    {
        $payment = $this->paymentService->processPayment($booking_id);
        if (!$payment) return $this->errorResponse('Booking not found', 404);
        return $this->successResponse($payment, 'Payment processed successfully');
    }

    public function show($id)
    {
        $payment = $this->paymentService->getPayment($id);
        if (!$payment) return $this->errorResponse('Payment not found', 404);
        return $this->successResponse($payment);
    }
}
