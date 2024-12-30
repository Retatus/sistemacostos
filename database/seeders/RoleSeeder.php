<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_editor = Role::create(['name' => 'editor']);

        $permission_create_role = Permission::create(['name' => 'create role']);
        $permission_read_role = Permission::create(['name' => 'read role']);
        $permission_update_role = Permission::create(['name' => 'update role']);
        $permission_delete_role = Permission::create(['name' => 'delete role']);

        $permission_create_categoria_proveedor = Permission::create(['name' => 'create categoria proveedor']);
        $permission_read_categoria_proveedor = Permission::create(['name' => 'read categoria proveedor']);
        $permission_update_categoria_proveedor = Permission::create(['name' => 'update categoria proveedor']);
        $permission_delete_categoria_proveedor = Permission::create(['name' => 'delete categoria proveedor']);

        $permission_admin = [$permission_create_role, $permission_read_role, $permission_update_role, $permission_delete_role, 
        $permission_create_categoria_proveedor,$permission_read_categoria_proveedor, $permission_update_categoria_proveedor, $permission_delete_categoria_proveedor];

        $permission_edito = [$permission_create_categoria_proveedor,$permission_read_categoria_proveedor, $permission_update_categoria_proveedor, $permission_delete_categoria_proveedor];

        $role_admin->syncPermissions($permission_admin);
        $role_editor->syncPermissions($permission_edito);
    }
}
