<?php

namespace Database\Seeders;

use App\Models\EventType as ModelsEventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = [
            "Dry Off",
            "Perawatan",
            "Vaksinasi",
            "Perkawinan",
            "Penyuburan",
            "Pemerahan",
            "Reproduksi",
            "Penjualan",
            "Penyembelihan",
            "Indentifikasi(Tagging)",
            "Other"
        ];

        foreach($eventTypes as $type) {
            ModelsEventType::create([
                'name' => $type,
                'slug' => \Illuminate\Support\Str::slug($type),
            ]);
        }
    }
}
