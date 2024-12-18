<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class LabourClientRoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check all ready exist labour role
        $labourRole = Role::where('name', 'labour')->first();
        if (!$labourRole) {
            // Create Labour Role
            $labourRole = Role::firstOrCreate(['name' => 'labour']);
        }
        // check all ready exist client role
        $clientRole = Role::where('name', 'client')->first();
        if (!$clientRole) {
            // Create Client Role
            $clientRole = Role::firstOrCreate(['name' => 'client']);
        }
        // Create Labour User
        $labourUser = User::firstOrCreate(
            ['email' => 'labour@example.com'], // Adjust email as required
            [
                'name' => 'Labour User',
                'password' => bcrypt('password'), // Replace with a secure password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        // Create Labour User
        $clientUser = User::firstOrCreate(
            ['email' => 'client@example.com'], // Adjust email as required
            [
                'name' => 'Client User',
                'password' => bcrypt('password'), // Replace with a secure password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        // Assign Role to Labour User
        $labourUser->assignRole($labourRole);
        // Assign Role to Labour User
        $clientUser->assignRole($clientRole);
    }
}
