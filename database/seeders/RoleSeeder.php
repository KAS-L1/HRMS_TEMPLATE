<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the roles to be created
        $roles = [
            'Super-Admin',
            'Admin',
            'Manager',
            'Vendor',
            'Logistic',
            'Auditor',
        ];

        // Loop through the roles and create them
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]); // Prevent duplicates
        }

        // Output success message
        $this->command->info('Roles seeded successfully!');
    }
}
