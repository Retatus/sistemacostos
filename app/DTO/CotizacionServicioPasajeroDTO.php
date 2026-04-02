<?php

namespace App\DTO;

class CotizacionServicioPasajeroDTO
{
    public function __construct(
        public int $pasajero_index, // Índice temporal para mapear con el pasajero en el DTO principal
        public int $pasajero_id,
        public float $precio,
        public int $cantidad,
        public float $descuento,
        public float $total
    ) {}

    // 🔹 BACKEND → FRONTEND
    public static function fromModel($model): self
    {
        return new self(
            pasajero_index: $model->pasajero_index,
            pasajero_id: $model->pasajero_id,
            precio: (float)$model->precio,
            cantidad: $model->cantidad,
            descuento: (float)$model->descuento,
            total: (float)$model->total
        );
    }

    // 🔹 FRONTEND → BACKEND
    public static function fromArray(array $data): self
    {
        return new self(
            pasajero_index: $data['pasajero_index'] ?? 0,
            pasajero_id: $data['pasajero_id'] ?? 0,
            precio: (float)($data['precio'] ?? 0),
            cantidad: (int)($data['cantidad'] ?? 1),
            descuento: (float)($data['descuento'] ?? 0),
            total: (float)($data['total'] ?? 0)
        );
    }
}