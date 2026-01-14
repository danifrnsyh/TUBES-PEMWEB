<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DebugUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug user role and details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User not found with email: $email");
            return 1;
        }

        $this->info("User found:");
        $this->line("ID: {$user->id}");
        $this->line("Name: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line("Role: {$user->role}");
        $this->line("Peran: {$user->peran}");
        
        return 0;
    }
}
