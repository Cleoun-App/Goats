<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goatBreeds = [
            "Alpine",
            "Nubian",
            "Saanen",
            "LaMancha",
            "Boer",
            "Angora",
            "Pygmy",
            "Toggenburg",
            "Kiko",
            "Cashmere",
            "Other"
            // Add more goat breeds as needed
        ];

        foreach ($goatBreeds as $breed) {
            Breed::create([
                'name' => $breed,
                'slug' => Str::slug($breed)
            ]);
        }
    }
}
