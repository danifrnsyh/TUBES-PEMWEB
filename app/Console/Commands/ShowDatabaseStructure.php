<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowDatabaseStructure extends Command
{
    protected $signature = 'db:show-structure';
    protected $description = 'Show exact database structure - helps debugging';

    public function handle()
    {
        $this->info('=== DATABASE STRUCTURE ===\n');

        $tables = ['users', 'pesanan', 'pesanan_item', 'produk', 'kategori_produk'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $this->info("✓ TABLE: $table");
                $columns = DB::getSchemaBuilder()->getColumnListing($table);
                $this->line("  Columns (" . count($columns) . "):");
                foreach ($columns as $col) {
                    $this->line("    - $col");
                }
            } else {
                $this->error("✗ TABLE MISSING: $table");
            }
            $this->line('');
        }

        // Show actual SQL structure
        $this->info('=== RAW SQL STRUCTURE ===\n');
        
        try {
            $result = DB::select('SHOW CREATE TABLE `pesanan_item`');
            if ($result) {
                $this->line($result[0]->{'Create Table'});
            }
        } catch (\Exception $e) {
            $this->error('Error getting SQL: ' . $e->getMessage());
        }

        return 0;
    }
}
