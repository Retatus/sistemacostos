<?php
namespace App\DTO;

use App\Models\Servicio;

class ServicioDTO
{   
    public function __construct(
        public int $id,
        public int $proveedor_id,
        public int $servicio_detalle_id,
        public int $ubicacion_id,
        public int $estado_activo,
        public ?PrecioDTO $precio = null,
        public ?ServicioDetalleDTO $servicio_detalles
    ) {}

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            proveedor_id: 0,
            servicio_detalle_id: 0,
            ubicacion_id: 0,
            estado_activo: 1,
            precio: PrecioDTO::createEmpty(),
            servicio_detalles: ServicioDetalleDTO::createEmpty(),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            proveedor_id: $data['proveedor_id'] ?? 0,
            servicio_detalle_id: $data['servicio_detalle_id'] ?? 0,
            ubicacion_id: $data['ubicacion_id'] ?? 0,
            estado_activo: $data['estado_activo'] ?? 1,
            precio: isset($data['precio']) ? PrecioDTO::fromArray($data['precio']) : null,
            servicio_detalles: isset($data['servicio_detalles']) ? ServicioDetalleDTO::fromArray($data['servicio_detalles']) : null
        );
    }
}
