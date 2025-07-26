<?php
namespace App\DTO;

class PrecioDTO {  
    public function __construct(
        public int $id,
        public int $anio,
        public string $moneda,
        public float $monto,
        public int $tipo_pasajero_id,
        public int $servicio_id,
        public int $servicio_clase_id,
        public int $estado_activo,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            anio: $data['anio'] ?? date('Y'),
            moneda: $data['moneda'] ?? 'USD',
            monto: (float) ($data['monto'] ?? 0),
            tipo_pasajero_id: $data['tipo_pasajero_id'] ?? 0,
            servicio_id: $data['servicio_id'] ?? 0,
            servicio_clase_id: $data['servicio_clase_id'] ?? 0,
            estado_activo: $data['estado_activo'] ?? 1,
        );
    }

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            anio: date('Y'),
            moneda: 'USD',
            monto: 0.0,
            tipo_pasajero_id: 0,
            servicio_id: 0,
            servicio_clase_id: 0,
            estado_activo: 1,
        );
    }
}
