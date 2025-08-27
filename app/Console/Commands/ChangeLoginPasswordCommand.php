<?php

namespace App\Console\Commands;

use App\Models\Login;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Change Login Password Command
 * 
 * USAGE: php artisan login:change-password {username} {password}
 * 
 * Changes the password of an existing login user. The password is automatically hashed.
 * 
 * ARGUMENTS:
 * - username: The username/email of the login user
 * - password: The new password (will be hashed automatically)
 * 
 * EXAMPLE:
 * $ php artisan login:change-password john@example.com newpassword123
 * 
 * Returns exit code 0 on success, 1 on failure.
 */
class ChangeLoginPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:change-password {username : The username/email of the login user} {password : The new password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the password of an existing login user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->argument('username');
        $newPassword = $this->argument('password');

        // Validate input
        if (empty($username)) {
            $this->error('Username cannot be empty');
            return 1;
        }

        if (empty($newPassword)) {
            $this->error('Password cannot be empty');
            return 1;
        }

        if (strlen($newPassword) < 6) {
            $this->error('Password must be at least 6 characters long');
            return 1;
        }

        try {
            // Find the login user
            $login = Login::where('LGN_Username', $username)->first();

            if (!$login) {
                $this->error("Login user with username '{$username}' not found");
                return 1;
            }

            // Update the password
            $login->LGN_Password = Hash::make($newPassword);
            $login->save();

            $this->info("Password successfully changed for user: {$login->LGN_Name} ({$login->LGN_Username})");
            $this->line("Updated at: {$login->updated_at}");

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to change password: ' . $e->getMessage());
            return 1;
        }
    }
} 