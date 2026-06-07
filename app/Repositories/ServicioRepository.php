<?php

namespace App\Repositories;

use App\Models\Servicio;

class ServicioRepository
{
    public static function Servicios(int $proveedor_id)
    {
        $servicios = Servicio::with([
                        'precios',
                        'servicioDetalles' => function($query) {
                            $query->select('id', 'descripcion', 'proveedor_categoria_id');
                        }
                    ])->where(['proveedor_id' => $proveedor_id, 'estado_activo' => 1])->orderBy('id', 'desc')->get();

        return $servicios;
    }

    public static function Servicio(int $id)
    {
        $servicio = Servicio::with([
                        'precios',
                        'servicioDetalles' => function($query) {
                            $query->select('id', 'descripcion', 'proveedor_categoria_id')
                                ->with([
                                    'proveedor_categoria:id,nombre'
                                ]);
                        },
                        'proveedor:id,ruc,razon_social,proveedor_categoria_id'
                    ])->where('id', $id)->first();

        return $servicio;
    }
}
