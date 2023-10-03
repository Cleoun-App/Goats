<?php

namespace Database\Factories;

use App\Models\EventType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fake = fake();

        $eventTypes = EventType::get();

        return [
            'name' => $fake->name,
            'type' => $eventTypes[rand(0, count($eventTypes) - 1)]?->name ?? $fake->sentence,
            'note' => $fake->sentence,
            'scope' => 'mass',
            'date' => now()->addDays(rand(1, 10)),
        ];
    }
}
