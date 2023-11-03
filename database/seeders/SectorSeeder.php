<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [

            'Belediye',
            'Hayvan Hastanesi',
            'Veteriner Kliniği',
            'Hayvan Oteli'

        ];

        foreach ($arr as $a) {

            Sector::create([
               'name' => $a
            ]);

        }

    }
}
