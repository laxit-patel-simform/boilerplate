<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (json_decode(file_get_contents(database_path('seeders/data/permissions.json')), true) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
