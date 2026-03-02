<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Serve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve {host=localhost:8000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $host = $this->argument('host') ?? 'localhost:8000';
        $public = base_path('public');

        $this->info("Starting PHP development server: http://{$host}");

        $command = PHP_BINARY . " -S {$host} -t " . escapeshellarg($public);

        passthru($command);

        return 0;
    }
}
