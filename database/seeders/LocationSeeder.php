<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared(file_get_contents(database_path('seeders/data/countries.sql')));
        DB::unprepared(file_get_contents(database_path('seeders/data/states.sql')));
        DB::unprepared(file_get_contents(database_path('seeders/data/cities.sql')));
    }
}
