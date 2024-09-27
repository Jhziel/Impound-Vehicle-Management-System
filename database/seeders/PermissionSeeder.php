<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'Manage Permissions'
        ]);

        Permission::create([
            'name' => 'Manage Drivers'
        ]);

        Permission::create([
            'name' => 'Manage Enforcers'
        ]);

        Permission::create([
            'name' => 'Manage Tickets'
        ]);

        Permission::create([
            'name' => 'Manage Users'
        ]);

        Permission::create([
            'name' => 'Manage Violations'
        ]);

        Permission::create([
            'name' => 'Manage Roles'
        ]);

        Permission::create([
            'name' => 'Manage Impound TIckets'
        ]);
    }
}
