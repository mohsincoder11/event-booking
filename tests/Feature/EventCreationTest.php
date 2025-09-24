<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class EventCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function organizer_can_create_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $payload = [
            'title' => 'Laravel Conference',
            'description' => 'Event Description',
            'date' => now()->addDays(10)->format('Y-m-d'),
            'location' => 'New York',
        ];

        $response = $this->actingAs($organizer, 'sanctum')
                         ->postJson('/api/events', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'data' => ['id', 'title', 'description', 'date', 'location', 'created_by']
                 ]);

        $this->assertDatabaseHas('event', ['title' => 'Laravel Conference']);
    }
}
