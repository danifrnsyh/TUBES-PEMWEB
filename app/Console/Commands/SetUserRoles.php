<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SetUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set default role for users without role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set role to 'buyer' for users without role
        $updated = DB::table('users')
            ->where(function ($query) {
                $query->whereNull('role')
                      ->orWhere('role', '')
                      ->orWhere('role', 'Pembeli')
                      ->orWhere('role', 'pembeli');
            })
            ->update(['role' => 'buyer']);

        $this->info("Updated {$updated} users to have role 'buyer'");
        
        // Also update peran to pegawai for seller
        $updated2 = DB::table('users')
            ->where('role', 'Pegawai')
            ->orWhere('role', 'pegawai')
            ->update(['role' => 'seller']);
            
        $this->info("Updated {$updated2} users to have role 'seller'");

        return 0;
    }
}
