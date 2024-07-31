<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApplicationSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will setup the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('This will Wipe Database, Continue ?')) {
            $this->call('migrate:fresh');
            $this->call('db:seed');
            $this->call('optimize:clear');
            $this->call('optimize');
            $this->call('config:clear');
        }
    }
}
