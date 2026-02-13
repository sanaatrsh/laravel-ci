<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Mrmarchone\LaravelAutoCrud\Helpers\PermissionNameResolver;
use Spatie\Permission\Models\Permission;

class UserPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $group = 'users';
        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($actions as $action) {
            $permissionName = PermissionNameResolver::resolve($group, $action);
            Permission::firstOrCreate(['name' => $permissionName]);
        }
    }
}
