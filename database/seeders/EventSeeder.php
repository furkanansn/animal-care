<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('events')->insert([
            'title' => 'Test Etkinlik',
            'content' => 'Test etkinlik açıklaması',
            'event_date' => '2020-12-12',
            'location' => 'Aydın/Efeler'
        ]);

        $val = [1, 2, 3, 4, 5];

        foreach ($val as $v) {
            \DB::table('galleries')->insert([
                'photo' => 'https://images.unsplash.com/photo-1601138052805-296bcfa3b28c?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8c21hbGwlMjBhbmltYWx8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
                'event_id' => 1
            ]);
        }
    }
}
