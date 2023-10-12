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

        $eventTypes = [
            "Dry Off",
            "Perawatan",
            "Vaksinasi",
            "Perkawinan",
            "Pemerahan",
            "Melahirkan",
            "Penyembelihan",
            "Indentifikasi(Tagging)",
            "Other"
        ];

        $event_type = $eventTypes[rand(0, count($eventTypes) - 1)] ?? "Other";

        $e_data = match($event_type) {
            "Dry Off" => [
                "goat_count" => rand(100, 900),
            ],
            "Perawatan" => [
                "diagnosis" => $fake->word,
                "treated_by" => $fake->lastName,
            ],
            "Melahirkan" => [
                "kids_no" => rand(1, 6),
                "father_tag" => rand(1000, 9000),
                "mother_tag" => rand(1000, 9000),
            ],
            "Vaksinasi" => [
                "vaccine" => $fake->word,
            ],
            "Perkawinan" => [
                "male_tag" => $fake->word,
                "female_tag" => $fake->word,
            ],
            "Pemerahan" => [
                "result" => rand(100, 900),
            ],
            "Pemberatan" => [
                "target_weight" => rand(1000, 9999),
                "gain_weight" => rand(1000, 9999),
            ],
            "Penyembelihan" => [
                "goat_count" => rand(100, 900),
            ],
            "Indentifikasi(Tagging)" => [
                "tag_no" => rand(100, 900),
            ],
            "Other" => [
                "event_name" => $fake->word,
                "event_desc" => $fake->sentence,
            ],
        };

        return [
            'name' => $fake->name,
            'type' => $event_type,
            'note' => $fake->sentence,
            'data' => $e_data,
            'scope' => 'mass',
            'date' => now()->addDays(rand(1, 10)),
        ];
    }
}
