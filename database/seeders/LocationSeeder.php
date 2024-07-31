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
        DB::unprepared(file_get_contents(storage_path('app/data/countries.sql')));
        DB::unprepared(file_get_contents(storage_path('app/data/states.sql')));
        DB::unprepared(file_get_contents(storage_path('app/data/cities.sql')));
    }
}
