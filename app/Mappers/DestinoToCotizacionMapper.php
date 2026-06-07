<?php

namespace App\Mappers;

use Illuminate\Support\Facades\Log;

class DestinoToCotizacionMapper
{
    public static function map($destino): array
    {
        return [
            'id' => $destino->id,
            'nombre' => $destino->nombre,
            'descripcion' => $destino->descripcion,
            'nro_dias' => $destino->nro_dias,
            'dias' => collect($destino->itinerarioDestinos)
                ->sortBy('nro_dia')
                ->values()
                ->map(function ($itDestino) {

                    return [
                        'dia' => $itDestino->nro_dia,
                        'nombre' => $itDestino->nombre,
                        'descripcion' => $itDestino->descripcion,
                        'observacion' => $itDestino->observacion,
                        'duracion' => $itDestino->itinerario->duracion,
                        'servicios' => ItinerarioServicioMapper::collection(
                            $itDestino->itinerarioServicios
                        )
                        // 'servicios' => collect($itDestino->itinerarioServicios)
                        //     ->sortBy('nro_orden')
                        //     ->values()
                        //     ->map(function ($itServ) {
                        //         $servicio = $itServ->servicio;
                        //         return [
                        //             'servicio_id' => $servicio->id,
                        //             'proveedor_id' => optional($servicio->proveedor)->id,
                        //             'orden' => $itServ->nro_orden,
                        //             'hora' => $itServ->hora,
                        //             'nombre_servicio' => optional($servicio->servicioDetalles)->descripcion,
                        //             'observacion' => $itServ->observacion,
                        //             'tipo_costo_id' => 1, // $itServ->tipo_costo,
                        //             'tipo_habitacion_id' => $itServ->tipo_habitacion,
                        //             'precio_id' => $itServ->precio_id,
                        //             'moneda' => $itServ->moneda,
                        //             'precio_unitario' => $itServ->monto,
                        //             //'precios' => self::mapPrecios($servicio),
                        //             'precios' => PreciosMapper::mapPrecios($servicio),
                        //             'cantidad' => 1,
                        //             'capacidad' => $servicio->capacidad,
                        //             'subtotal' => $itServ->monto,

                        //             'categoria_id' => optional($servicio->servicioDetalles)->proveedor_categoria_id,
                        //             'categoria' => optional($servicio->servicioDetalles)->proveedor_categoria->nombre,                                    
                        //             'ruc' => optional($servicio->proveedor)->ruc,
                        //             'proveedor' => optional($servicio->proveedor)->razon_social,
                        //             // 🔥 catálogo de precios (clave)

                        //             'pasajeros' => []
                        //         ];
                        //     })
                    ];
                })
                ->toArray()
        ];
    }

    // private static function mapPrecios($servicio): array
    // {
    //     return collect($servicio->precios)
    //         ->sortBy('id')
    //         ->values()
    //         ->map(function ($p) {
    //             return [
    //                 'id' => $p->id,
    //                 'descripcion' => self::buildDescripcion($p),
    //                 'tipo_costo' => $p->tipo_costo,                    
    //                 'precio' => (float) $p->monto,
    //                 'moneda' => $p->moneda
    //             ];
    //         })->values()->toArray();
    // }
   
    // private static function buildDescripcion($precio): string
    // {
    //     return match ($precio->tipo_costo) {
    //         'UNITARIO' => 'PAX',
    //         'GRUPAL' => 'GRUPO',
    //         default => $precio->tipo_costo
    //     };
    // }
}