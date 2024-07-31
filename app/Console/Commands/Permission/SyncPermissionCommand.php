<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncPermissionCommand extends Command
{
    protected $signature = 'app:permission:sync {--force : Force the synchronization by detaching permissions from roles}';

    protected $description = 'Sync permissions from file to database';

    public function handle()
    {
        $filePath = database_path('seeders/PermissionSeederData.php');
        $filePermissions = include $filePath;
        $databasePermissions = Permission::pluck('name')->toArray();

        // Add new permissions from the file to the database
        $permissionsToAdd = array_diff($filePermissions, $databasePermissions);
        foreach ($permissionsToAdd as $permission) {
            Permission::create(['name' => $permission]);
            $this->info("Permission '{$permission}' added to the database.");
        }

        // Remove deleted permissions from the file in the database
        $permissionsToRemove = array_diff($databasePermissions, $filePermissions);
        foreach ($permissionsToRemove as $permission) {
            $permissionModel = Permission::where('name', $permission)->first();
            if ($permissionModel) {
                $rolesWithPermission = Role::whereHas('permissions', function ($query) use ($permission) {
                    $query->where('name', $permission);
                })->get();
                if ($rolesWithPermission->isNotEmpty()) {
                    $this->error("Permission '{$permission}' is assigned to the following roles:");
                    foreach ($rolesWithPermission as $role) {
                        $this->line($role->name);
                    }
                    if ($this->option('force')) {
                        $this->line("Detaching the permission '{$permission}' from the roles.");
                        foreach ($rolesWithPermission as $role) {
                            $role->revokePermissionTo($permission);
                        }
                    }
                }

                if ($this->option('force') || $rolesWithPermission->isEmpty()) {
                    $permissionModel->delete();
                    $this->info("Permission '{$permission}' removed from the database.");
                }
            }
        }

        $this->info('Permissions have been synchronized between the file and the database.');
    }
}
