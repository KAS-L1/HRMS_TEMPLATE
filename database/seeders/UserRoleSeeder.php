<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        $usersWithRoles = [
            [
                'email' => 'superadmin@example.com',
                'role' => 'Super-Admin',
            ],
            [
                'email' => 'admin@example.com',
                'role' => 'Admin',
            ],
        ];

        foreach ($usersWithRoles as $userData) {
            $user = User::where('email', $userData['email'])->first();

            if ($user) {
                // Create the role if it doesn't exist
                $role = Role::firstOrCreate(['name' => $userData['role']]);

                // Assign the role to the user
                $user->assignRole($role->name);

                $this->command->info("Role '{$userData['role']}' assigned to user '{$user->email}'");
            } else {
                $this->command->warn("User with email '{$userData['email']}' not found.");
            }
        }
    }
}
