<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create zones
        foreach ([
            ['name' => 'Zone 1', 'code' => 'Z1'],
            ['name' => 'Zone 2', 'code' => 'Z2'],
            ['name' => 'Zone 3', 'code' => 'Z3'],
            ['name' => 'Zone 4', 'code' => 'Z4']
        ] as $zoneData) {
            $zone = Zone::create($zoneData);

            foreach (City::inRandomOrder()->limit(rand(5, 10))->get() as $city) {
                $zone->entities()->create([
                    'entity_id' => $city->id,
                    'entity_type' => get_class($city)
                ]);
            }
        }
    }
}
