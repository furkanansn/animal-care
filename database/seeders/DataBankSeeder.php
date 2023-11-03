<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_banks')->insert([
           'title' => 'Hayvanlar hakkında',
            'content' => 'E bu da hayvanlar hakkında',
            'view_count' => 0,
            'category_id' => 1
        ]);
    }
}
