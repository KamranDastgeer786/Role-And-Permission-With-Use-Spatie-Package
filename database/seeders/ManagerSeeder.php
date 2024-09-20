<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new user for the Manager role
        $user = User::create([
            'name' => 'ManagerUser',
            'email' => 'managertest@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);

        // Create the Manager role
        $role = Role::create(['name' => 'Manager']);

        // Define the permissions to be assigned to the Manager role
        $permissions = Permission::whereIn('name', [
            'show_products',
            'create_products',
            'edit_products',
            'show_categories',
            'create_categories',
            'edit_categories',
            'show_users',
            'create_users',
            'edit_users',
        ])->pluck('id')->all();

        // Assign the selected permissions to the Manager role
        $role->syncPermissions($permissions);

        // Assign the Manager role to the created user
        $user->assignRole('Manager');
    }
}
