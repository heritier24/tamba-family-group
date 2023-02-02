<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class PermissionCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new permission';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissionName = $this->ask("entering permission name");

        Permission::create([
            "name" => $permissionName
        ]);

        $this->info("successfully created permission called " . $permissionName);

        return 0;
    }
}
