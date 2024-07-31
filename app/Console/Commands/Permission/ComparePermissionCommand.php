<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class ComparePermissionCommand extends Command
{
    protected $signature = 'app:permission:compare';

    protected $description = 'Sync permissions from file to database';

    public function handle()
    {
        $filePermissions = include database_path('seeders/PermissionSeederData.php');
        $databasePermissions = Permission::pluck('name')->toArray();

        $onlyInFile = array_diff($filePermissions, $databasePermissions);
        $onlyInDatabase = array_diff($databasePermissions, $filePermissions);

        if (empty($onlyInFile) && empty($onlyInDatabase)) {
            $this->info('No differences found. Permissions are in sync.');
        } else {
            if (!empty($onlyInFile)) {
                $this->info('Permissions found in file but not in database:');
                foreach ($onlyInFile as $permission) {
                    $this->line($permission);
                }
            }

            if (!empty($onlyInDatabase)) {
                $this->info('Permissions found in database but not in file:');
                foreach ($onlyInDatabase as $permission) {
                    $this->line($permission);
                }
            }
        }
    }
}
