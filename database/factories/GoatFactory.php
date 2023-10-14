<?php

namespace Database\Factories;

use App\Models\Breed;
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

        $goat_breeds = Breed::all();

        $origins = [
            'Melahirkan Di Kandang', 
            'Kambing Hutan', 
            'Dibeli Di Pasar', 
            'Kambing Eropa',
            'Kambing A5 Jepang',
        ];

        $namaKambing = [
            "Merry",
            "Blackie",
            "Brownie",
            "Daisy",
            "Ginger",
            "Luna",
            "Oreo",
            "Penny",
            "Samantha",
            "Ruby",
            "Lilly",
            "Chloe",
            "Buddy",
            "Coco",
            "Rocky",
            "Charlie",
            "Molly",
            "Milo",
            "Rosie",
            "Bailey",
            "Lucy",
            "Bella",
            "Max",
            "Sadie",
            "Toby",
            "Leo",
            "Piper",
            "Lola",
            "Oscar",
            "Duke",
            "Cinnamon",
            "Simba",
            "Tiger",
            "Sasha",
            "Mocha",
            "Peanut",
            "Nala",
            "Smokey",
            "Felix",
            "Jasper",
            "Riley",
            "Sophie",
            "Lulu",
            "Ziggy",
            "Apollo",
            "Sammy",
            "Whiskers",
            "Princess",
            "Kitty",
            "Bentley",
            "Oliver",
            "Abby",
            "Tigger",
            "Cupcake",
            "Hazel",
            "Lenny",
            "Cooper",
            "Missy",
            "Zeus",
            "Roxy",
            "Sunny",
            "Ollie",
            "Olive",
            "Bear",
            "Bentley",
            "Finn",
            "Lola",
            "Shadow",
            "Angel",
            "Gizmo",
            "Holly",
            "Mittens",
            "Marley",
            "Winston",
            "Patches",
            "Simba",
            "Zeus",
            "Hannah",
            "Dexter",
            "Bubbles",
            "Salem",
            "Pumpkin",
            "Kiki",
            "Misty",
            "Fiona",
            "Panda",
            "Pebbles",
            "Cleopatra",
            "Boots",
            "Princess",
            "Simone",
            "Binx",
            "Taz",
            "Frankie",
            "Tigger",
            "Stella",
            "Minnie",
            "Mickey",
            "Socks",
            "Cupcake",
            "Shadow",
            "Fluffy",
            "Noodles",
        ];
        

        return [
            'name' => $namaKambing[rand(0, count($namaKambing) - 1)],
            'tag' => rand(10000, 99999),
            'global_tag' => md5(uniqid() . time()),
            'picture' => $fake->url(),
            'gender' => ['male', 'female'][rand(0, 1)],
            'origin' => $origins[rand(0, count($origins) - 1)],
            'breed' => $goat_breeds[rand(0, count($goat_breeds) - 1)]->name,
            'status' => ['alive', 'death', 'sold'][rand(0, 2)],
            'birth_date' => now()->addMonths(rand(-10, -99)),
            'date_in' => now()->addDay(rand(-10, 10)),
            'note' => $fake->sentence,
            'weight' => rand(1000, 99999),
        ];
    }
}
