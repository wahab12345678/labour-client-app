<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check all ready exist admin role
        $adminRole = Role::where('name', 'admin')->first();
        if (!$adminRole) {
            // Create Admin Role
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
        }
        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Adjust email as required
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), // Replace with a secure password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        // Assign Role to Admin User
        $adminUser->assignRole($adminRole);
    }
}
