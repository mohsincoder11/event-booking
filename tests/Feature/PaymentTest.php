<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Ticket;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_make_mock_payment_for_booking()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id, 'price' => 100, 'quantity' => 10]);
        $booking = Booking::factory()->create([
            'user_id' => $customer->id,
            'ticket_id' => $ticket->id,
            'quantity' => 2,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($customer, 'sanctum')
                         ->postJson("/api/bookings/{$booking->id}/payment");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => ['id', 'booking_id', 'amount', 'status']
                 ]);

        $this->assertDatabaseHas('payment', ['booking_id' => $booking->id, 'status' => 'success']);
    }
}
