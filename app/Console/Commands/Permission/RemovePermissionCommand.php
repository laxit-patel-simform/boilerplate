<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class RemovePermissionCommand extends Command
{
    protected $signature = 'app:permission:remove {name : The name of the permission}';

    protected $description = 'Remove a permission';

    public function handle()
    {
        $permissionName = $this->argument('name');

        // Check if the permission exists in the database
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission) {
            $permission->delete();
            $this->info("Permission '{$permissionName}' removed from the database.");
        } else {
            $this->error("Permission '{$permissionName}' does not exist in the database.");
            return;
        }

        // Remove the permission from the file
        $filePath = database_path('seeders/PermissionSeederData.php');
        $permissions = include $filePath;
        $key = array_search($permissionName, $permissions);
        if ($key !== false) {
            unset($permissions[$key]);
            file_put_contents($filePath, '<?php return ' . var_export($permissions, true) . ';');
            $this->info("Permission '{$permissionName}' removed from the file.");
        } else {
            $this->error("Permission '{$permissionName}' does not exist in the file.");
        }
    }
}
