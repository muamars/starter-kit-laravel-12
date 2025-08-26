<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Blog permissions
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',

            // Project permissions
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',

            // User management permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role management permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $writerRole = Role::create(['name' => 'Writer']);
        $managerRole = Role::create(['name' => 'Manager']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());

        $writerRole->givePermissionTo([
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
        ]);

        $managerRole->givePermissionTo([
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
        ]);

        // Create default users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@example.com',
            'password' => bcrypt('password'),
        ]);
        $writer->assignRole('Writer');

        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('Manager');
    }
}
