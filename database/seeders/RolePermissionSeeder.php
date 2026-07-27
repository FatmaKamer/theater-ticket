<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roller
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Yetkiler (Permissions)
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view venues', 'create venues', 'edit venues', 'delete venues',
            'view plays', 'create plays', 'edit plays', 'delete plays',
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // Admin tüm yetkilere sahip
        $admin->givePermissionTo($permissions);
    }
}
