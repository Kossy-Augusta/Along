<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create category',
            'edit category',
            'update category'
        ];

        $role = Role::firstOrCreate(['name'=>'admin']);

        foreach($permissions as $permission)
        {
            $perm = Permission::firstOrCreate(['name'=> $permission]);
            $role->givePermissionTo($perm);
        }

    }
}
