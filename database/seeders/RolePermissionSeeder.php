<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Get all permissions
        $permissions = Permission::all();

        // Assign all permissions to Super-Admin
        $superAdminRole = Role::firstOrCreate(['name' => 'Super-Admin']);
        $superAdminRole->syncPermissions($permissions);

        // Assign all permissions to Admin
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions($permissions);

        // Output success message
        $this->command->info('Permissions assigned to roles successfully!');
    }
}
