<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            ['Board' => '01DB', 'Area_CC' => 'Arima'],
            ['Board' => '02CC', 'Area_CC' => 'Chaguanas/Caroni'],
            ['Board' => '03CF', 'Area_CC' => 'Couva/Tabaquite/Talparo'],
            ['Board' => '04MM', 'Area_CC' => 'Diego Martin/St George West'],
            ['Board' => '05FF', 'Area_CC' => 'Mayaro/Rio Claro'],
            ['Board' => '06JJ', 'Area_CC' => 'Penal/Debe/Siparia/St Patrick East'],
            ['Board' => '07KK', 'Area_CC' => 'Point Fortin/ St Patrick West'],
            ['Board' => '08AA', 'Area_CC' => 'Port of Spain/St George Central'],
            ['Board' => '09HH', 'Area_CC' => 'Princes Town/Victoria East'],
            ['Board' => '10GG', 'Area_CC' => 'San Fernando/Victoria West'],
            ['Board' => '11AB', 'Area_CC' => 'San Juan/Laventille/St George East'],
            ['Board' => '12DD', 'Area_CC' => 'Sangre Grande/St Andrew'],
            ['Board' => '13LL', 'Area_CC' => 'Tobago'],
            ['Board' => '14EE', 'Area_CC' => 'Toco/St David'],
            ['Board' => '15BB', 'Area_CC' => 'Tunapuna/Piarco'],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
