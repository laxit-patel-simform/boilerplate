<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class AddPermissionCommand extends Command
{
    protected $signature = 'app:permission:add {name : The name of the permission}';

    protected $description = 'Add a new permission';

    public function handle()
    {
        $permissionName = $this->argument('name');

        // Check if the permission already exists in the database
        if (Permission::where('name', $permissionName)->exists()) {
            $this->error("Permission '{$permissionName}' already exists in the database.");
            return;
        }

        // Create the permission in the database
        Permission::create(['name' => $permissionName]);
        $this->info("Permission '{$permissionName}' added to the database.");

        // Add the permission to the file
        $filePath = database_path('seeders/PermissionSeederData.php');
        $permissions = include $filePath;
        if (!in_array($permissionName, $permissions)) {
            $permissions[] = $permissionName;
            file_put_contents($filePath, '<?php return ' . var_export($permissions, true) . ';');
            $this->info("Permission '{$permissionName}' added to the file.");
        } else {
            $this->error("Permission '{$permissionName}' already exists in the file.");
        }
    }
}
