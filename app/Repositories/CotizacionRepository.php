<?php

namespace App\Repositories;

use App\Models\Cotizacion;
use App\Models\DestinoTuristico;

class CotizacionRepository
{
    public static function DestinoSeleccionado(int $destinoId)
    {
        return DestinoTuristico::with([
            'dias' => function($query) {
                $query->with([
                    'itinerario',
                    'servicios' => function($query) {
                        $query->with([
                            'servicio' => function($query) {
                                $query->with([
                                    'precios',
                                    'servicioDetalles' => function($query) {
                                        $query->select('id', 'descripcion', 'proveedor_categoria_id')
                                            ->with([
                                                'proveedor_categoria:id,nombre'
                                            ]);
                                    },
                                    'proveedor:id,ruc,razon_social,proveedor_categoria_id'
                                ]);
                            }
                        ]);
                    }
                ]);
            }
        ])->find($destinoId);
    }

    public static function EditarCotizacion(int $id)
    {
        return Cotizacion::with([
            'dias' => function($query) {
                $query->with([
                    'servicios' => function($query) {
                        $query->with([
                            'servicio' => function($query) {
                                $query->with([
                                    'precios',
                                    'servicioDetalles' => function($query) {
                                        $query->select('id', 'descripcion', 'proveedor_categoria_id')
                                            ->with([
                                                'proveedor_categoria:id,nombre'
                                            ]);
                                    },
                                    'proveedor:id,ruc,razon_social,proveedor_categoria_id'
                                ]);
                            }
                        ]);
                    }
                ]);
            },
            'pasajeros'
        ])->find($id);
    }
}