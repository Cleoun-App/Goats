<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Preference;

class PreferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preference::create([
            'key'   =>  'visual.mode',
            'name' => 'Mode Tampilan',
        ]);
    }
}
