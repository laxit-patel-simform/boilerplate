<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as BaseCommand;

class ApplicationSetupCommand extends Command
{
    protected $signature = 'app:setup {--force : Skip confirmation prompts}';

    protected $description = 'This Command will setup the application';

    public function handle(): int
    {
        $this->newLine();
        $this->info('🔧 <fg=green>Starting Application Setup...</>');
        $this->newLine();

        try {
            DB::connection()->getPdo();
            $this->components->twoColumnDetail('🗄️ Checking Database Connection', '<fg=green>Successful</>');
        } catch (Exception $e) {
            $this->components->warn("Database Does Not Exists! Aborting the process");
            return BaseCommand::FAILURE;
        }

        if ($this->option('force') || $this->confirm('⚠️ <fg=yellow>This will wipe the database. Continue?</>')) {
            $this->setup();
            return BaseCommand::SUCCESS;
        } else {
            $this->components->alert("Setup Aborted");
            return BaseCommand::FAILURE;
        }
    }

    protected function setup(): void
    {
        $this->newLine();
        $this->components->twoColumnDetail('🔄 Migrating and Seeding Database...', '<fg=yellow>In Progress</>');
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->components->twoColumnDetail('🔄 Migrating and Seeding Database', '<fg=green>Done</>');

        $this->newLine();
        $this->components->twoColumnDetail('🧹 Clearing and Optimizing Cache...', '<fg=yellow>In Progress</>');
        $this->call('optimize:clear');
        $this->call('optimize');
        $this->components->twoColumnDetail('🧹 Clearing and Optimizing Cache', '<fg=green>Done</>');

        $this->newLine();
        $this->components->twoColumnDetail('⚙️ Clearing Configuration Cache...', '<fg=yellow>In Progress</>');
        $this->call('config:clear');
        $this->components->twoColumnDetail('⚙️ Clearing Configuration Cache', '<fg=green>Done</>');

        $this->newLine();
        $this->components->success('✅ <fg=green>Application setup completed! BUILD SOMETHING MAJESTIC</>');
        $this->newLine();
    }

    protected function checkDatabaseConnection(): ?string
    {

    }
}
