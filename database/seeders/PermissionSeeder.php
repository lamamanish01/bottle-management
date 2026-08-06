<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

             // ================= USERS =================
            'view dashboard',

            // ================= USERS =================
            'view users',
            'create users',
            'edit users',
            'delete users',

            // ================= ROLES =================
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // ================= PERMISSIONS =================
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // ================= COLLECTORS =================
            'view collectors',
            'create collectors',
            'edit collectors',
            'delete collectors',

            // ================= SUPPLIERS =================  <-- new
            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'delete suppliers',

            // ================= BUYERS =================
            'view buyers',
            'create buyers',
            'edit buyers',
            'delete buyers',

            // ================= BOTTLE TYPES =================
            'view bottle-types',
            'create bottle-types',
            'edit bottle-types',
            'delete bottle-types',

            // ================= COLLECTIONS =================
            'view collections',
            'create collections',
            'edit collections',
            'delete collections',

            // ================= SALES =================
            'view sales',
            'create sales',
            'edit sales',
            'delete sales',

            // ================= PAYMENTS =================
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',

            // ================= EXPENSES =================
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web'
            ]);
        }
    }
}
