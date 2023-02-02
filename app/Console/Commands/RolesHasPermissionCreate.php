<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesHasPermissionCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rolesPermission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'give roles permissions to the specified';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = Role::all(['id', 'name']);

        $this->table(
            ['id', 'name'],
            $roles
        );
        $idrole = $this->ask("entering role id");
        $role = Role::findById($idrole);

        $permissions = Permission::all(['id', 'name']);
        $this->table(['id', 'name'], $permissions);
        $permissionid = $this->ask("entering permission id");

        $permission = Permission::findById($permissionid);

        $role->givePermissionTo($permission);

        $this->info("successfully role has permission");

        return 0;
    }
}
