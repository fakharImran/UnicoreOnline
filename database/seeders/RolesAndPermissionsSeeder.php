<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'company-index',
            'company-create',
            'company-edit',
            'company-delete',
            'user-index',
            'user-create',
            'user-edit',
            'user-delete',
            'ticket-index',
            'ticket-create',
            'ticket-edit',
            'ticket-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'no_access']);

        // Create roles and assign permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(
            'company-index',
            'company-create',
            'company-edit',
            'company-delete',
            'user-index',
            'user-create',
            'user-edit',
            'user-delete',
            'ticket-index',
            'ticket-create',
            'ticket-edit',
            'ticket-delete',
        );  

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(
            'ticket-index',
            'ticket-create',
            'ticket-edit',
        );

        $no_access= Role::findByName('no_access');
        $no_access->givePermissionTo();
    }
}
