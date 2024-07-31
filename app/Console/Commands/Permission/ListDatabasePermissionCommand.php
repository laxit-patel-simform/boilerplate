<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class ListDatabasePermissionCommand extends Command
{
    protected $signature = 'app:permission:list:db';

    protected $description = 'List all permissions';

    public function handle()
    {
        $permissions = Permission::latest()->get(['id', 'name', 'guard_name']);

        if ($permissions->isEmpty()) {
            $this->info('No permissions found.');
        } else {
            $headers = ['ID', 'Name', 'Guard Name'];
            $permissionsData = $permissions->map(function ($permission) {
                return $permission->toArray();
            });

            $this->table($headers, $permissionsData);
        }
    }
}
