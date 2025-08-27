<?php

namespace App\Console\Commands;

use App\Models\Login;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Create Login Command
 * 
 * USAGE: php artisan login:create
 * 
 * Creates a new login user with hashed password. Prompts for:
 * - Name (max 50 chars)
 * - Username/Email (max 50 chars, unique)
 * - Password (min 6 chars, confirmed)
 * - Role (numeric, default: 1)
 * 
 * EXAMPLE:
 * $ php artisan login:create
 * Enter the user's name: John Doe
 * Enter the user's email/username: john@example.com
 * Enter the password: ******
 * Confirm the password: ******
 * Enter the user role (default: 1): 2
 * 
 * Returns exit code 0 on success, 1 on failure.
 */
class CreateLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new login user with name, email, and password';

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
        $this->info('Creating a new login user...');
        $this->line('');

        // Get user inputs
        $name = $this->ask('Enter the user\'s name');
        $email = $this->ask('Enter the user\'s email/username');
        $password = $this->secret('Enter the password');
        $passwordConfirmation = $this->secret('Confirm the password');

        // Validate inputs
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:50|unique:logins,LGN_Username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }
            return 1;
        }

        // Ask for role (default to 1 if not specified)
        $role = $this->ask('Enter the user role (default: 1)', '1');
        if (!is_numeric($role)) {
            $this->error('Role must be a number');
            return 1;
        }

        try {
            // Create the login record
            $login = new Login();
            $login->LGN_Name = $name;
            $login->LGN_Username = $email;
            $login->LGN_Password = Hash::make($password);
            $login->LGN_Role = (int) $role;
            $login->save();

            $this->info('');
            $this->info('Login user created successfully!');
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $login->LGN_ID],
                    ['Name', $login->LGN_Name],
                    ['Username/Email', $login->LGN_Username],
                    ['Role', $login->LGN_Role],
                    ['Created At', $login->created_at],
                ]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create login user: ' . $e->getMessage());
            return 1;
        }
    }
}
