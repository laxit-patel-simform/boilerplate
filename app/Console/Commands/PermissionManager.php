<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class PermissionManager extends Command
{
    protected $signature = 'app:permission
                            {action : The action to perform (list|create|remove|compare|sync)}
                            {--source= : The source (db|file)}
                            {--name= : The name of the permission for create or remove}
                            {--force : Force the action}';
    protected $description = 'Manage permissions between database and JSON file';

    private $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->filePath = storage_path('app/data/permissions.json');
    }

    public function handle()
    {
        $action = $this->argument('action');
        $source = $this->option('source');
        $name = $this->option('name');
        $force = $this->option('force');

        switch ($action) {
            case 'list':
                $this->listPermissions($source);
                break;
            case 'create':
                $this->createPermission($source, $name);
                break;
            case 'remove':
                $this->removePermission($source, $name, $force);
                break;
            case 'compare':
                $this->comparePermissions();
                break;
            case 'sync':
                $this->syncPermissions();
                break;
            default:
                $this->error('Invalid action. Use list, create, remove, compare, or sync.');
        }
    }

    private function listPermissions($source)
    {
        if ($source === 'file') {
            $permissions = json_decode(file_get_contents($this->filePath), true);
        } else {
            $permissions = Permission::all()->pluck('name')->toArray();
        }

        $this->info('Permissions:');
        foreach ($permissions as $permission) {
            $this->info($permission);
        }
    }

    private function createPermission($source, $name)
    {
        if (!$name) {
            $this->error('Permission name is required for create action.');
            return;
        }

        if ($source === 'file') {
            $permissions = json_decode(file_get_contents($this->filePath), true);
            if (!in_array($name, $permissions)) {
                $permissions[] = $name;
                file_put_contents($this->filePath, json_encode($permissions, JSON_PRETTY_PRINT));
                $this->info('Permission added to file.');
            } else {
                $this->info('Permission already exists in file.');
            }
        } else {
            Permission::firstOrCreate(['name' => $name]);
            $this->info('Permission added to database.');
        }
    }

    private function removePermission($source, $name, $force)
    {
        if (!$name) {
            $this->error('Permission name is required for remove action.');
            return;
        }

        if ($source === 'file') {
            $permissions = json_decode(file_get_contents($this->filePath), true);
            if (($key = array_search($name, $permissions)) !== false) {
                unset($permissions[$key]);
                file_put_contents($this->filePath, json_encode(array_values($permissions), JSON_PRETTY_PRINT));
                $this->info('Permission removed from file.');
            } else {
                $this->info('Permission not found in file.');
            }
        } else {
            $permission = Permission::where('name', $name)->first();
            if ($permission) {
                $roles = $permission->roles;
                if ($roles->isNotEmpty() && !$force) {
                    $this->error('Permission is assigned to one or more roles. Use --force to remove it.');
                    return;
                }

                $permission->delete();
                $this->info('Permission removed from database.');
            } else {
                $this->info('Permission not found in database.');
            }
        }
    }

    private function comparePermissions()
    {
        $filePermissions = json_decode(file_get_contents($this->filePath), true);
        $dbPermissions = Permission::all()->pluck('name')->toArray();

        $inFileNotInDb = array_diff($filePermissions, $dbPermissions);
        $inDbNotInFile = array_diff($dbPermissions, $filePermissions);

        $this->info('Permissions in file but not in database:');
        foreach ($inFileNotInDb as $permission) {
            $this->info($permission);
        }

        $this->info('Permissions in database but not in file:');
        foreach ($inDbNotInFile as $permission) {
            $this->info($permission);
        }
    }

    private function syncPermissions()
    {
        $filePermissions = json_decode(file_get_contents($this->filePath), true);
        $dbPermissions = Permission::all()->pluck('name')->toArray();

        // Add permissions to DB from file if not present
        foreach ($filePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Add permissions to file from DB if not present
        foreach ($dbPermissions as $permission) {
            if (!in_array($permission, $filePermissions)) {
                $filePermissions[] = $permission;
            }
        }

        file_put_contents($this->filePath, json_encode($filePermissions, JSON_PRETTY_PRINT));
        $this->info('Permissions synced between database and file.');
    }
}
