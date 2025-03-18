<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class HloesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hloes')->insert([
            'Hloe_Code' => 'PS',
            'Hloe_Desc' => 'Primary'
        ]);
        DB::table('hloes')->insert([
            'Hloe_Code' => 'SS',
            'Hloe_Desc' => 'Secondary'
        ]);
        DB::table('hloes')->insert([
            'Hloe_Code' => 'TL',
            'Hloe_Desc' => 'Tertiary'
        ]);
        DB::table('hloes')->insert([
            'Hloe_Code' => 'TV',
            'Hloe_Desc' => 'Technical/Vocational'
        ]);
        DB::table('hloes')->insert([
            'Hloe_Code' => 'ZO',
            'Hloe_Desc' => 'Other'
        ]);

    }
}
