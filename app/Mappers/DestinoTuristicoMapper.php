<?php

namespace App\Mappers;

class DestinoTuristicoMapper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function fromDestino($destino)
    {
        $cotizacion = [
            'destino_id' => $destino->id,
            'pasajeros' => [],
            'dias' => []
        ];

        foreach ($destino->itinerarioDestinos as $itDestino) {

            $dia = [
                'dia' => $itDestino->itinerario->dia,
                'servicios' => []
            ];

            foreach ($itDestino->itinerarioServicios as $itServicio) {

                $servicio = $itServicio->servicio;

                $servDTO = [
                    'servicio_id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'proveedor' => optional($servicio->proveedor)->razon_social,

                    // 🔥 catálogo de precios
                    'precios' => $servicio->precios->map(function ($precio) {
                        return [
                            'id' => $precio->id,
                            'descripcion' => $precio->descripcion ?? null,
                            'precio' => $precio->precio
                        ];
                    })->values()->toArray(),

                    // valores iniciales
                    'precio_id' => null,
                    'cantidad' => 1,
                    'pasajeros' => []
                ];

                $dia['servicios'][] = $servDTO;
            }

            $cotizacion['dias'][] = $dia;
        }

        return $cotizacion;
    }

    public static function fromModel($cotizacion)
    {
        return [
            'destino_id' => $cotizacion->destino_id,
            'pasajeros' => $cotizacion->pasajeros,
            'dias' => $cotizacion->dias->map(function ($dia) {
                return [
                    'dia' => $dia->dia,
                    'servicios' => $dia->servicios->map(function ($serv) {

                        return [
                            'servicio_id' => $serv->servicio_id,
                            'nombre' => $serv->nombre,

                            // 🔥 catálogo (puede venir de snapshot o servicio)
                            'precios' => json_decode($serv->precios_json ?? '[]', true),

                            'precio_id' => $serv->precio_id,
                            'cantidad' => $serv->cantidad,
                            'pasajeros' => $serv->pasajeros
                        ];

                    })->toArray()
                ];
            })->toArray()
        ];
    }
}
