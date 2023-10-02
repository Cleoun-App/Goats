<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MilkNote>
 */
class MilkNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fake = fake();

        $types = ['individual', 'bulk'];

        $type = $types[rand(0, 1)];

        return [
            'date' => now()->addDays(rand(1, 9)),
            'type' => $type,
            'note' => $fake->sentence,
            'produced' => rand(0, 100),
            'consumption' => rand(0, 100),
            'goats_milked' => $type == 'bulk' ? rand(1, 10) : null,
            'goat_id' => $type == 'individual' ? rand(1, 10) : null,
            
        ];
    }
}
