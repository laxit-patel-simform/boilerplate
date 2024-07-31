<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // By default admin will inherit all the permissions
        $superRole = Role::firstOrCreate(['name' => 'SUPER ADMIN']);
        $superRole->givePermissionTo(Permission::all());
    }
}
