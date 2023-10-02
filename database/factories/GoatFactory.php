<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goat>
 */
class GoatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fake = fake();

        $goat_breeds = [
            'keia', 'alwi', 'weij', 'jeins', 'aj'
         ];

        $cos_point = cos(round(time()/pi()));

        return [
            'name' => $fake->name,
            'tag' => md5(rand(100, 999) * .14 + time() / $cos_point),
            'global_tag' => md5(uniqid() . time()),
            'picture' => $fake->url(),
            'gender' => ['male', 'female'][rand(0, 1)],
            'origin' => ['Di curi', 'Di ambil di peternakan orang', 'Dibeli tampa bayar', 'Melahirkan di kandang orang'][rand(0, 3)],
            'breed' => $goat_breeds[rand(0, count($goat_breeds) - 1)],
            'status' => ['alive', 'death', 'sold'][rand(0, 2)],
            'birth_date' => now()->addMonths(rand(-10, -99)),
            'date_in' => now()->addDay(rand(-10, 10)),
            'note' => $fake->sentence,
            'weight' => rand(100, 999),
        ];
    }
}
