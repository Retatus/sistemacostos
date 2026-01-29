<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache de Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 🔥 Limpiar tablas (orden importante)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /*
        |--------------------------------------------------------------------------
        | PERMISOS (ÁRBOL LÓGICO)
        |--------------------------------------------------------------------------
        */

        // -----------------------------
        // PERMISOS
        // -----------------------------
        $permissions = [
            // proveedorCategorías
            'proveedorCategorias.view',
            'proveedorCategorias.create',
            'proveedorCategorias.update',
            'proveedorCategorias.delete',

            // Proveedores
            'proveedores.view',
            'proveedores.create',
            'proveedores.update',
            'proveedores.delete',

            // ServicioDetalle
            'servicioDetalle.view',
            'servicioDetalle.create',
            'servicioDetalle.update',
            'servicioDetalle.delete',

            // Servicios
            'servicios.view',
            'servicios.create',
            'servicios.update',
            'servicios.delete',

            // Destinos turísticos
            'destinos.view',
            'destinos.create',
            'destinos.update',
            'destinos.delete',

            // Itinerarios
            'itinerarios.view',
            'itinerarios.create',
            'itinerarios.update',
            'itinerarios.delete',            

            // Precios
            'precios.view',
            'precios.create',
            'precios.update',

            // Clientes
            'clientes.view',
            'clientes.create',
            'clientes.update',
            'clientes.delete',

            // Cotizaciones
            'cotizaciones.view',
            'cotizaciones.create',
            'cotizaciones.update',
            'cotizaciones.delete',
            'cotizaciones.export',
            'cotizaciones.approve',

            // Pasajeros
            'pasajeros.view',
            'pasajeros.create',
            'pasajeros.update',
            'pasajeros.delete',

            // Reportes
            'reportes.view',
            'reportes.export',

            // Usuarios
            'usuarios.view',
            'usuarios.create',
            'usuarios.update',
            'usuarios.delete',

            // Auditoría (TI)
            'auditoria.view',
            'auditoria.export',

            // Sistema (TI)
            'sistema.manage',
        ];

        // Crear permisos
        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        // -----------------------------
        // ROLES
        // -----------------------------
        $roles = [
            // TI / PROPIETARIO
            'super_admin',
            'soporte_ti',
            'auditor',

            // AGENCIA
            'admin',
            'reservas',
            'operaciones',
            'contabilidad',
            'soporte'            
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // -----------------------------
        // ASIGNACIÓN DE PERMISOS A ROLES
        // -----------------------------

        // SUPER ADMIN → TODO
        Role::findByName('super_admin')->syncPermissions(Permission::all());

        // ADMIN
        Role::findByName('admin')->syncPermissions([
            'proveedorCategorias.view',
            'proveedorCategorias.create',
            'proveedorCategorias.update',
            'proveedorCategorias.delete',

            'proveedores.view',
            'proveedores.create',
            'proveedores.update',
            'proveedores.delete',

            'servicioDetalle.view',
            'servicioDetalle.create',
            'servicioDetalle.update',
            'servicioDetalle.delete',

            'servicios.view',
            'servicios.create',
            'servicios.update',
            'servicios.delete',

            'destinos.view',
            'destinos.create',
            'destinos.update',
            'destinos.delete',

            'itinerarios.view',
            'itinerarios.create',
            'itinerarios.update',
            'itinerarios.delete',

            'precios.view',

            'clientes.view',
            'clientes.create',
            'clientes.update',
            'clientes.delete',

            'cotizaciones.view',
            'cotizaciones.create',
            'cotizaciones.update',
            'cotizaciones.delete',
            'cotizaciones.export',

            'pasajeros.view',
            'pasajeros.create',
            'pasajeros.update',
            'pasajeros.delete',

            'usuarios.view',
            'usuarios.create',
            'usuarios.update',
        ]);

        // RESERVAS
        Role::findByName('reservas')->syncPermissions([
            'proveedores.view',
            'cotizaciones.view',
            'cotizaciones.create',
            'cotizaciones.update',
            'pasajeros.view',
            'pasajeros.create',
            'pasajeros.update',
        ]);

        // OPERACIONES
        Role::findByName('operaciones')->syncPermissions([
            'itinerarios.view',
            'itinerarios.create',
            'itinerarios.update',
            'itinerarios.delete',
            'proveedores.view',
            'cotizaciones.view',
            'pasajeros.view',
        ]);

        // CONTABILIDAD
        Role::findByName('contabilidad')->syncPermissions([
            'precios.view',
            'precios.update',
            'cotizaciones.view',
            'cotizaciones.export',
            'reportes.view',
        ]);

        // SOPORTE AGENCIA
        Role::findByName('soporte')->syncPermissions([
            'proveedores.view',
            'cotizaciones.view',
            'pasajeros.view',
        ]);

        // SOPORTE TI
        Role::findByName('soporte_ti')->syncPermissions([
            'usuarios.view',
            'usuarios.update',
            'auditoria.view',
            'reportes.view',
        ]);

        // AUDITOR
        Role::findByName('auditor')->syncPermissions([
            'auditoria.view',
            'auditoria.export',
            'reportes.view',
        ]);
    }
}
