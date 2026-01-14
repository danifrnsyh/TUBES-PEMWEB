<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FixDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:database {--fresh : Drop all tables and re-run migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix database issues by running migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            if ($this->option('fresh')) {
                $this->info('Running migrate:fresh...');
                Artisan::call('migrate:fresh', ['--seed' => true]);
                $this->info('Database reset and seeded successfully!');
            } else {
                $this->info('Running migrations...');
                Artisan::call('migrate');
                $this->info('Migrations completed!');
            }
            
            $this->info('Verifying database...');
            Artisan::call('verify:database');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
