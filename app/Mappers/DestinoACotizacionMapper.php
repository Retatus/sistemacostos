<?php

namespace App\Mappers;

class DestinoACotizacionMapper
{
    public static function map($destino): array
    {
        return [
            'id' => $destino->id,
            'nombre' => $destino->nombre,
            'descripcion' => $destino->descripcion,
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
                        'servicios' => collect($itDestino->itinerarioServicios)
                            ->sortBy('nro_orden')
                            ->values()
                            ->map(function ($itServ) {

                                $servicio = $itServ->servicio;

                                return [
                                    'servicio_id' => $servicio->id,
                                    'hora' => $itServ->hora,

                                    'nombre' => optional($servicio->servicioDetalles)->descripcion,
                                    'categoria' => optional($servicio->servicioDetalles)->proveedor_categoria->nombre,

                                    'proveedor' => optional($servicio->proveedor)->razon_social,

                                    // catálogo de precios
                                    'moneda' => $servicio->precios[0]->moneda ?? 'USD',
                                    'precios' => self::mapPrecios($servicio),

                                    // selección del usuario
                                    'precio_id' => null,
                                    'cantidad' => 1,
                                    'pasajeros' => []
                                ];
                            })
                    ];
                })
                ->toArray()
        ];
    }

    private static function mapPrecios($servicio): array
    {
        // 🔥 1. Si existen precios GRUPAL → agrupar por servicio
        $preciosGrupales = collect($servicio->precios)->where('tipo_costo', 'GRUPAL');

        if ($preciosGrupales->isNotEmpty()) {
            return self::mapPreciosGrupales($preciosGrupales, $servicio->id);
        }

        // 🔥 2. Si hay catálogo de proveedor (habitaciones o transportes)
        if (!empty($servicio->proveedor->catalogo_transportes)) {
            return self::mapCatalogoTransportes($servicio->proveedor->catalogo_transportes);
        }

        if (!empty($servicio->proveedor->catalogo_habitaciones)) {
            return self::mapCatalogoHabitaciones($servicio->proveedor->catalogo_habitaciones);
        }

        // 🔥 3. Precios simples
        return collect($servicio->precios)->map(function ($p) {
            return [
                'id' => $p->id,
                'anio' => $p->anio,
                'descripcion' => self::buildDescripcion($p),
                'precio' => (float) $p->monto,
                'moneda' => $p->moneda,
                'tipo_costo' => $p->tipo_costo,
                'tipo_habitacion' => $p->tipo_habitacion,
                'capacidad_pax' => $p->capacidad_pax,
                'pax_min' => $p->pax_min,
                'pax_max' => $p->pax_max,
            ];
        })->values()->toArray();
    }

    // 🔥 NUEVO: agrupación exclusiva para GRUPAL
    private static function mapPreciosGrupales($precios, $servicioId): array
    {
        return [
            'servicio_id' => $servicioId,
            'items' => $precios->map(function ($p) {
                return [
                    'id' => $p->id,
                    'tipo_habitacion' => $p->tipo_habitacion,
                    'capacidad_pax' => $p->capacidad_pax,
                    'pax_min' => $p->pax_min,
                    'pax_max' => $p->pax_max,
                    'precio' => (float) $p->monto,
                    'moneda' => $p->moneda
                ];
            })->values()->toArray()
        ];
    }

    private static function mapCatalogoTransportes($catalogo): array
    {
        return collect($catalogo)->flatMap(function ($item) {
            return collect($item['tarifas'])->map(function ($tarifa) use ($item) {
                return [
                    'id' => $tarifa['precio_id'],
                    'descripcion' => strtoupper($item['tipo']) . ' - ' . $tarifa['tipo_costo'],
                    'precio' => $tarifa['precio'],
                    'moneda' => $tarifa['moneda'],
                    'capacidad' => $item['capacidad']
                ];
            });
        })->values()->toArray();
    }

    private static function mapCatalogoHabitaciones($catalogo): array
    {
        return collect($catalogo)->flatMap(function ($item) {
            return collect($item['tarifas'])->map(function ($tarifa) use ($item) {
                return [
                    'id' => $tarifa['precio_id'],
                    'descripcion' => strtoupper($item['tipo']),
                    'precio' => $tarifa['precio'],
                    'moneda' => $tarifa['moneda']
                ];
            });
        })->values()->toArray();
    }

    private static function buildDescripcion($precio): string
    {
        return match ($precio->tipo_costo) {
            'UNITARIO' => 'PAX',
            'GRUPAL' => 'GRUPO',
            default => $precio->tipo_costo
        };
    }
}
