<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [ 'Servis Elektronik', 'Servis Kendaraan (Motor)', 'Servis Kendaraan (Mobil)', 
            'Servis WC', 'Wastafel', 'Penjahit', 'Programmer', 'Mobile Dev', 'Web Dev', 'Software Dev', 
            'Animator', 'Designer', 'UI/UX', 'Servis AC', 'Jasa Pembuatan Dapur', 'Jasa Instalasi Listrik'];


        foreach ($categories as $cat) {

            Category::create([
                'name' => $cat,
                'slug' => \Str::slug($cat)
            ]);

        }
    }
}
