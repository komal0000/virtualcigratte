<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating a new admin user...');

        // Prompt the user for admin details
        $email = $this->ask('Enter the admin email');
        $password = $this->ask('Enter the admin password');
        // Check if the email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');
            return Command::FAILURE;
        }

        // Create the admin user
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true, // Assuming you have an `is_admin` column in your users table
        ]);

        if ($user) {
            $this->info('Admin user created successfully!');
            return Command::SUCCESS;
        } else {
            $this->error('Failed to create admin user.');
            return Command::FAILURE;
        }
    }
}
