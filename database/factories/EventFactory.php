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

        $vaksinasiKambing = [
            [
                "jenis" => "Clostridium perfringens",
                "deskripsi" => "Melindungi dari infeksi bakteri Clostridium perfringens yang dapat menyebabkan gangguan pencernaan."
            ],
            [
                "jenis" => "Pasteurella",
                "deskripsi" => "Melindungi dari infeksi Pasteurella, penyebab penyakit pernapasan."
            ],
            [
                "jenis" => "Campylobacter",
                "deskripsi" => "Mengendalikan infeksi bakteri Campylobacter yang memengaruhi sistem reproduksi."
            ],
            [
                "jenis" => "Brucellosis",
                "deskripsi" => "Melindungi dari infeksi Brucellosis yang memengaruhi reproduksi dan bisa ditularkan kepada manusia."
            ],
            [
                "jenis" => "Chlamydia",
                "deskripsi" => "Melindungi dari infeksi Chlamydia yang memengaruhi sistem reproduksi."
            ],
            [
                "jenis" => "Toxoplasmosis",
                "deskripsi" => "Melindungi dari infeksi Toxoplasmosis yang mengganggu kesehatan reproduksi dan bisa ditularkan kepada manusia."
            ],
            [
                "jenis" => "Salmonella",
                "deskripsi" => "Mengendalikan infeksi Salmonella yang menyebabkan masalah pencernaan."
            ],
            [
                "jenis" => "Leptospirosis",
                "deskripsi" => "Melindungi dari infeksi bakteri Leptospirosis yang memengaruhi ginjal dan menyebabkan gejala seperti demam."
            ],
            [
                "jenis" => "Penyakit Campak Kambing (PPR)",
                "deskripsi" => "Melindungi dari penyakit PPR yang mirip dengan penyakit campak pada manusia."
            ],
            [
                "jenis" => "Anthrax",
                "deskripsi" => "Melindungi dari infeksi bakteri Anthrax yang bisa menjadi penyakit serius."
            ],
            [
                "jenis" => "Rift Valley Fever (RVF)",
                "deskripsi" => "Melindungi dari penyakit Rift Valley Fever yang memengaruhi sistem pernapasan dan reproduksi."
            ],
            [
                "jenis" => "Orf (Contagious Ecthyma)",
                "deskripsi" => "Melindungi dari penyakit Orf, yang merupakan penyakit virus kulit."
            ],
            [
                "jenis" => "Caseous Lymphadenitis",
                "deskripsi" => "Melindungi dari penyakit yang disebabkan oleh bakteri Corynebacterium pseudotuberculosis yang menyebabkan abses."
            ]
        ];

        $eventTypes = [
            "Dry Off",
            "Perawatan",
            "Vaksinasi",
            "Perkawinan",
            "Pemerahan",
            "Melahirkan",
            "Pemberatan",
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
                "vaccine" => $vaksinasiKambing[rand(0, count($vaksinasiKambing) - 1)]['jenis'],
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
