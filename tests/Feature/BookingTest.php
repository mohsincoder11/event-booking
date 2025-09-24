<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_book_ticket()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id, 'quantity' => 10]);

        $payload = ['quantity' => 2];

        $response = $this->actingAs($customer, 'sanctum')
                         ->postJson("/api/tickets/{$ticket->id}/bookings", $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'data' => ['id', 'user_id', 'ticket_id', 'quantity', 'status']
                 ]);

        $this->assertDatabaseHas('booking', ['user_id' => $customer->id, 'ticket_id' => $ticket->id]);
    }
}
