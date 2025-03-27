<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IncomesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incomes')->insert([
            'INC_Code' => '1_U3K',
            'INC_Desc' => 'Under 3000'
        ]);
        DB::table('incomes')->insert([
            'INC_Code' => '2_3-5',
            'INC_Desc' => '3000-5000'
        ]);
        DB::table('incomes')->insert([
            'INC_Code' => '3_5-7',
            'INC_Desc' => '5001-7000'
        ]);
        DB::table('incomes')->insert([
            'INC_Code' => '4_7-10',
            'INC_Desc' => '7001-10,000'
        ]);
        DB::table('incomes')->insert([
            'INC_Code' => '5_10-15',
            'INC_Desc' => '10,001-15,000'
        ]);
        DB::table('incomes')->insert([
            'INC_Code' => '6_O15K',
            'INC_Desc' => '15,001 and above'
        ]);
    }
}
