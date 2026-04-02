<?php

namespace App\DTO;

class CotizacionServicioDTO
{
    public function __construct(
        public ?int $id,
        public ?int $servicio_id,
        public ?int $proveedor_id,
        public ?int $orden,
        public ?string $hora,
        public ?string $nombre_servicio,
        public ?string $observacion,
        public ?int $tipo_costo_id,
        public ?int $tipo_habitacion_id,
        public ?int $precio_id,
        public ?string $moneda,
        public ?float $precio_unitario,
        public ?int $cantidad,
        public ?int $capacidad,
        public ?float $subtotal,
        public ?string $estado_activo,        
        public array $pasajeros = []
    ) {}

    // 🔹 BACKEND → FRONTEND
    public static function fromModel($model): self
    {
        return new self(

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
            precio_unitario: (float)$model->precio_unitario,
            cantidad: $model->cantidad,
            subtotal: (float)$model->subtotal,
            capacidad: $model->capacidad,
            estado_activo: $model->estado_activo,

            pasajeros: $model->pasajeros
                ->map(fn($p) => CotizacionServicioPasajeroDTO::fromModel($p))
                ->toArray()
        );
    }

    // 🔹 FRONTEND → BACKEND
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            servicio_id: $data['servicio_id'] ?? null,
            proveedor_id: $data['proveedor_id'] ?? null,
            orden: $data['orden'] ?? 0,
            hora: $data['hora'] ?? null,
            nombre_servicio: $data['nombre_servicio'] ?? null,
            observacion: $data['observacion'] ?? null,
            tipo_costo_id: $data['tipo_costo_id'] ?? null,
            tipo_habitacion_id: $data['tipo_habitacion_id'] ?? null,
            precio_id: $data['precio_id'] ?? null,
            moneda: $data['moneda'] ?? 'USD',
            precio_unitario: (float)($data['precio_unitario'] ?? 0),
            cantidad: (int)($data['cantidad'] ?? 1),
            capacidad: (int)($data['capacidad'] ?? 0),
            subtotal: (float)($data['subtotal'] ?? 0),
            estado_activo: $data['estado_activo'] ?? null,

            pasajeros: array_map(
                fn($p) => CotizacionServicioPasajeroDTO::fromArray($p),
                $data['pasajeros'] ?? []
            )
        );
    }
}