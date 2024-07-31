<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ApplicationRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output      = new ConsoleOutput();
        $progressBar = new ProgressBar($output, 3);
        $table       = new Table($output);
        $chmodRow    = [];

        $progressBar->start();

        $progressBar->advance();
        Artisan::call('optimize:clear');

        $progressBar->advance();
        Artisan::call('optimize');

        $progressBar->advance();
        Artisan::call('config:clear');

        $progressBar->advance();
        Artisan::call('route:clear');

        $chmodStatus = 0;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'LIN') {
            exec("sudo chmod -R 777 storage bootstrap/cache", $chmodOutput, $chmodStatus);
            array_push($chmodRow, ["sudo chmod -R 777 storage bootstrap/cache", $chmodStatus === 0 ? '✔️ Success' : '❌ Failed']);
        } else {
            array_push($chmodRow, ["sudo chmod -R 777 storage bootstrap/cache", "❗Not Supported"]);
        }

        $progressBar->finish();
        $output->writeln('');

        $table->setHeaders(['Command', 'Status']);
        $table->setRows([['optimize:clear', '✔️Clearing Optimization Cache'],
            ['optimize', '✔️ Optimizing'],
            ['config:clear', '✔️ Clearing Config'],
            ['route:clear', '✔️ Clearing Route Cache'],
            $chmodRow[0]
        ]);
        $table->render();
    }
}
