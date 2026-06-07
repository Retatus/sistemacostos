<?php

namespace App\Factory;

use App\DTO\CotizacionServicioDTO;
use App\Models\CotizacionServicio;

class CotizacionServicioPasajeroFactory
{
    public function __construct(
        private PasajeroFactory $pasajeroFactory,
    ) {}

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

    public static function fromArray(array $data): CotizacionServicioDTO
    {
        return new CotizacionServicioDTO(
            id: $data['id'] ?? null,
            servicio_id: $data['servicio_id'] ?? null,
            proveedor_id: $data['proveedor_id'] ?? null,
            orden: $data['orden'] ?? null,
            hora: $data['hora'] ?? null,
            nombre_servicio: $data['nombre_servicio'] ?? null,
            observacion: $data['observacion'] ?? null,
            tipo_costo_id: $data['tipo_costo_id'] ?? null,
            tipo_habitacion_id: $data['tipo_habitacion_id'] ?? null,
            precio_id: $data['precio_id'] ?? null,
            moneda: $data['moneda'] ?? null,
            precio_unitario: $data['precio_unitario'] ?? null,
            cantidad: $data['cantidad'] ?? null,
            capacidad: $data['capacidad'] ?? null,
            subtotal: $data['subtotal'] ?? null,
            estado_activo: $data['estado_activo'] ?? null,
            pasajeros: array_map(
                fn($pasajero) => $this->pasajeroFactory->fromArray($pasajero),
                $data['pasajeros'] ?? []
            )
        );
    }

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
            pasajeros: array_map(
                fn($pasajero) => $this->pasajeroFactory->fromModel($pasajero),
                $model->pasajeros ?? []
            )
        );
    }
}
