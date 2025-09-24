<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['VIP','Standard','Economy']),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(10, 100),
            'event_id' => Event::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
