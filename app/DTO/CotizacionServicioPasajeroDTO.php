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
}