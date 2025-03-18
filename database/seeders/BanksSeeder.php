<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('banks')->insert([
            'BANK_Code' => '1FCB',
            'BANK_Desc' => 'First Citizens Bank'
        ]);
        DB::table('banks')->insert([
            'BANK_Code' => '2SB',
            'BANK_Desc' => 'Scotiabank'
        ]);
        DB::table('banks')->insert([
            'BANK_Code' => '3RBC',
            'BANK_Desc' => 'Royal Bank of Canada'
        ]);
        DB::table('banks')->insert([
            'BANK_Code' => '4RB',
            'BANK_Desc' => 'Republic Bank Limited'
        ]);
        DB::table('banks')->insert([
            'BANK_Code' => '5CU',
            'BANK_Desc' => 'Credit Union'
        ]);
        DB::table('banks')->insert([
            'BANK_Code' => 'OTH',
            'BANK_Desc' => 'Other'
        ]);
        DB::table('banks')->insert([
            'BANK_Code' => 'N/A',
            'BANK_Desc' => 'None'
        ]);

    }
}
