<?php

namespace App\Factory;

use App\DTO\CotizacionServicioDTO;
use App\Models\CotizacionServicio;
use Illuminate\Support\Facades\Log;

class CotizacionServicioFactory
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private CotizacionServicioPasajeroFactory $pasajeroFactory,
    ) {}

    /**
     * Create an empty class instance.
     */
    public static function createEmpty(): CotizacionServicioDTO
    {        
        return new CotizacionServicioDTO(
            id: null,
            servicio_id: null,
            proveedor_id: null,
            orden: null,
            hora: null,
            nombre_servicio: null,
            observacion: null,
            tipo_costo_id: null,
            tipo_habitacion_id: null,
            precio_id: null,
            moneda: null,
            precio_unitario: 0.00,
            cantidad: 0,
            capacidad: 0,
            subtotal: 0.00,
            estado_activo: 1,
            pasajeros: [] // 🔥 vacío
        );
    }

    // 🔹 FRONTEND → BACKEND
    public static function fromArray(array $data): CotizacionServicioDTO
    {
        Log::debug('CotizacionServicioFactory::fromArray', ['data' => $data]);
        return new CotizacionServicioDTO(
            id: $data['id'] ?? null,
            servicio_id: $data['servicio_id'] ?? 0,
            proveedor_id: $data['proveedor_id'] ?? 0,
            orden: $data['orden'] ?? 0,
            hora: $data['hora'] ?? '',
            nombre_servicio: $data['nombre_servicio'] ?? '',
            observacion: $data['observacion'] ?? '',
            tipo_costo_id: $data['tipo_costo_id'] ?? 1,
            tipo_habitacion_id: $data['tipo_habitacion_id'] ?? null,
            precio_id: $data['precio_id'] ?? 0,
            moneda: $data['moneda'] ?? '',
            precio_unitario: (float) ($data['precio_unitario'] ?? 0),
            cantidad: $data['cantidad'] ?? 0,
            capacidad: $data['capacidad'] ?? 0,
            subtotal: (float) ($data['subtotal'] ?? 0),
            estado_activo: $data['estado_activo'] ?? 1,
            pasajeros: array_map(
                fn($pasajero) => PasajeroFactory::fromArray($pasajero),
                // fn($pasajero) => CotizacionServicioPasajeroFactory::fromArray($pasajero), --- IGNORE ---
                 $data['pasajeros'] ?? []
             )
        );
    }

    // 🔹 BACKEND → FRONTEND
    public static function fromModel(CotizacionServicio $model): CotizacionServicioDTO
    {
        return new CotizacionServicioDTO(
            id: $model->id,
            servicio_id: $model->servicio_id,
            proveedor_id: $model->proveedor_id,
            orden: $model->orden,
            hora: $model->hora,
            nombre_servicio: $model->nombre_servicio,
            observacion: $model->observacion,
            tipo_costo_id: $model->tipo_costo_id,
            tipo_habitacion_id: $model->tipo_habitacion_id,
            precio_id: $model->precio_id,
            moneda: $model->moneda,
            precio_unitario: (float) $model->precio_unitario,
            cantidad: $model->cantidad,
            capacidad: $model->capacidad,
            subtotal: (float) $model->subtotal,
            estado_activo: $model->estado_activo,
            pasajeros: $model->pasajeros ? $model->pasajeros
                    ->map(fn($p) => PasajeroFactory::fromModel($p))
                    ->toArray()
                : [],
        );
    }
}
