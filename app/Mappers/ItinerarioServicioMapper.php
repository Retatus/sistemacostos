<?php

namespace App\Mappers;

use Illuminate\Support\Facades\Log;

class ItinerarioServicioMapper
{
    /**
     * =====================================================
     * MAPEAR ITEM SERVICIO ITINERARIO
     * =====================================================
     */
    public static function map($itServ): array
    {
        $servicio = $itServ->servicio;
        // Log::info('Mapeando servicio',$servicio->precios->toArray());
        return [
            'id' => $itServ->id,
            'servicio_id' => $servicio->id,
            'proveedor_id' => optional($servicio->proveedor)->id,
            'orden' => $itServ->nro_orden,
            'hora' => $itServ->hora,
            'nombre_servicio' => optional($servicio->servicioDetalles)->descripcion,
            'observacion' => $itServ->observacion,
            'tipo_costo_id' => 1,
            'tipo_habitacion_id' => $itServ->tipo_habitacion,
            'precio_id' => $itServ->precio_id,
            'moneda' => $itServ->moneda,
            'precio_unitario' => $itServ->monto,
            //'precios' => PreciosMapper::mapPrecios($servicio),
            'precios' => $servicio->precios,
            'cantidad' => 1,
            'capacidad' => $servicio->capacidad,
            'subtotal' => $itServ->monto,
            'categoria_id' => optional($servicio->servicioDetalles)->proveedor_categoria_id,
            'categoria' => optional(optional($servicio->servicioDetalles)->proveedor_categoria)->nombre,
            'ruc' => optional($servicio->proveedor)->ruc,
            'proveedor' => optional($servicio->proveedor)->razon_social,
            'pasajeros' => []
        ];
    }

    /**
     * =====================================================
     * MAPEAR COLECCIÓN
     * =====================================================
     */
    public static function collection($items)
    {
        return collect($items)
            ->map(fn($item) => self::map($item))
            ->values();
    }
}
