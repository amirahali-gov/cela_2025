<?php

namespace Database\Seeders;

use App\Models\Login;
use Illuminate\Database\Seeder;

class LoginsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logins = [
            [
                'LGN_Username' => 'admin',
                'LGN_Password' => 'admin123',
                'LGN_Name' => 'System Administrator',
                'LGN_Role' => 1
            ],

        ];

        foreach ($logins as $login) {
            Login::create($login);
        }
    }
} 