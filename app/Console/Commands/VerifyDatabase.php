<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VerifyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify database schema and tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = ['users', 'pesanan', 'pesanan_item', 'produk', 'kategori_produk', 'pengiriman'];
        
        $this->info("=== Database Schema Verification ===\n");
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $this->info("✓ Table '{$table}' exists");
                
                // Get columns
                $columns = DB::getSchemaBuilder()->getColumnListing($table);
                foreach ($columns as $col) {
                    $this->line("  - $col");
                }
            } else {
                $this->error("✗ Table '{$table}' NOT FOUND");
            }
            $this->line('');
        }
        
        return 0;
    }
}
