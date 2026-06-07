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
}