<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class RolesCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new role';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roleName = $this->ask("entering role name");

        Role::create(['name' =>  $roleName]);

        $this->info("New role created successfully");

        return 0;
    }
}
