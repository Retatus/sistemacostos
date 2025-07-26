<?php
namespace App\DTO;

use App\Models\Servicio;

class ServicioDetalleDTO
{
    public function __construct(
        public int $id,
        public int $nro_orden,
        public int $servicio_id,
        public int $itinerario_destino_id,
        public int $proveedor_categoria_id,
        public int $proveedor_id,
        public string $observacion,
        public string $monto,
        public int $estado_activo
    ) {} 

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            nro_orden: 0,
            servicio_id: 0,
            itinerario_destino_id: 0,
            proveedor_categoria_id: 0,
            proveedor_id: 0,
            observacion: '',
            monto: '0.00',
            estado_activo: 1
        );
    }
    
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            nro_orden: $data['nro_orden'] ?? 0,
            servicio_id: $data['servicio_id'] ?? 0,
            itinerario_destino_id: $data['itinerario_destino_id'] ?? 0,
            proveedor_categoria_id: $data['proveedor_categoria_id'] ?? 0,
            proveedor_id: $data['proveedor_id'] ?? 0,
            observacion: $data['observacion'] ?? '',
            monto: $data['monto'] ?? '0.00',
            estado_activo: $data['estado_activo'] ?? 1
        );
    }
}