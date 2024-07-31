<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Food',
            'Beverages',
            'Stationery',
            'Clothes',
            'Furniture',
            'Electronics',
            'Books',
            'Toys',
            'Sports',

        ] as $category) {
            Category::create(['name' => $category]);
        }
    }
}
