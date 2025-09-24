<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Booking;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $booking = Booking::inRandomOrder()->first();
        return [
            'booking_id' => $booking->id ?? 1,
            'amount' => $booking ? $booking->ticket->price * $booking->quantity : $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['success','failed','refunded']),
        ];
    }
}
