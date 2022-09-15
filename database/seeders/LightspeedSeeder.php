<?php

namespace ModularLightspeed\ModularLightspeed\database\Seeders;

use Illuminate\Database\Seeder;
use ModularLightspeed\ModularLightspeed\Models\Lightspeed;

class LightspeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lightspeed::factory()->create([
            'language' => 'nl',
            'shop_id' => '276198',
            'cluster_id' => 'eu1',
            'token' => '988a26507dd1d21cd3302474ac368497',
            'api_key' => '4a62f41eff46c118a0c5d3514f604aa0dbf53f23',
        ]);
    }
}
