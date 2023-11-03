<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $title = [

            'Aydın\'da tasmalı köpek!',
            'Bulvar üstünde 3 yavru kedi!',
            'Köpeğim Pera Kayboldu!',

        ];

        $content = [

            'Aydındaki bulvar üzerinde tasmalı köpek bulunmuştur',
            'Bulvardaki anne kedi doğurdu, yavrularına yuva lazım.',
            '1 yaşındaki Terrier cinsi köpeğim kayıp!'

        ];

        foreach ($title as $key => $val) {

            \DB::table('notices')->insert([

                'user_id' => 1,
                'title' => $val,
                'content' => $content[$key],
                'district_id' => 255,
                'image' => 'sdf'

            ]);

        }

    }
}
