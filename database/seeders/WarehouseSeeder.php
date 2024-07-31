<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            [
                'name' => 'Warehouse 1',
                'code' => 'W1',
                'zone_id' => 1
            ],
            [
                'name' => 'Warehouse 2',
                'code' => 'W2',
                'zone_id' => 2
            ],
            [
                'name' => 'Warehouse 3',
                'code' => 'W3',
                'zone_id' => 3
            ],
        ] as $warehouse) {
            $warehouse = Warehouse::create($warehouse);
            $warehouse->stock()->create([
                'stock' => rand(0, 100),
                'product_id' => 1,
            ]);
        }
    }
}
