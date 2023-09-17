<?php

namespace Database\Seeders;

use App\Models\EventType as ModelsEventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = [
            "Pemeriksaan kesehatan",
            "Penambahan berat badan",
            "Vaksinasi",
            "Perawatan Kesehatan",
            "Pemeliharaan Kebersihan Kandang",
            "Pemerahan Susu",
            "Pengawinan",
            "Reproduksi",
            "Penjualan",
            "Penyembelihan"
        ];

        foreach($eventTypes as $type) {
            ModelsEventType::create([
                'name' => $type,
                'slug' => \Illuminate\Support\Str::slug($type),
            ]);
        }
    }
}
