<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask("Entering names of the user ");

        $email = $this->ask("Entering email address");

        $password = $this->ask("Entering password");

        $user = User::create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password)
        ]);

        $user->assignRole('Admin', 'Secretary');  // this is to assign role to user 

        $this->info("user created successfully");
        return 0;
    }
}
