<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;


class ListFilePermissionCommand extends Command
{
    protected $signature = 'app:permission:list:file';

    protected $description = 'List all permissions';

    public function handle()
    {
        $filePath = database_path('seeders/PermissionSeederData.php');

        if (!file_exists($filePath)) {
            $this->error('File not found.');
            return;
        }

        $permissions = include $filePath;

        if (empty($permissions)) {
            $this->info('No permissions found in the file.');
        } else {
            $permissionsData = collect($permissions);

            $this->info('Permissions:');
            foreach ($permissionsData as $permission) {
                $this->line($permission);
            }
        }
    }
}
