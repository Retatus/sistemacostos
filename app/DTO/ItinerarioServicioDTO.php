<?php
 namespace App\DTO;

use App\Models\Servicio;

class ItinerarioServicioDTO
{
    public int $nro_orden;
    public int $servicio_id;
    public int $itinerario_destino_id;
    public int $proveedor_categoria_id;
    public int $proveedor_id;
    public string $observacion;
    public float $monto;
    public int $estado_activo;
    public array $servicio = []; // Assuming this is a single DTO, not a collection

    public function __construct(
        int $nro_orden,
        int $servicio_id,
        int $itinerario_destino_id,
        int $proveedor_categoria_id,
        int $proveedor_id,
        string $observacion,
        float $monto,
        int $estado_activo,
        array $servicio = []  
    ) {
        $this->nro_orden = $nro_orden;
        $this->servicio_id = $servicio_id;
        $this->itinerario_destino_id = $itinerario_destino_id;
        $this->proveedor_categoria_id = $proveedor_categoria_id;
        $this->proveedor_id = $proveedor_id;
        $this->observacion = $observacion;
        $this->monto = $monto;
        $this->estado_activo = $estado_activo;
        $this->servicio = $servicio;
    }

    public static function createEmpty(): self
    {
        return new self(
            nro_orden: 0,
            servicio_id: 0,
            itinerario_destino_id: 0,
            proveedor_categoria_id: 0,
            proveedor_id: 0,
            observacion: '',
            monto: 0.0,
            estado_activo: 1,
            servicio: [ServicioDTO::createEmpty()]
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nro_orden: $data['nro_orden'] ?? 0,
            servicio_id: $data['servicio_id'] ?? 0,
            itinerario_destino_id: $data['itinerario_destino_id'] ?? 0,
            proveedor_categoria_id: $data['proveedor_categoria_id'] ?? 0,
            proveedor_id: $data['proveedor_id'] ?? 0,
            observacion: $data['observacion'] ?? '',
            monto: (float) ($data['monto'] ?? 0.0),
            estado_activo: $data['estado_activo'] ?? 1,
            servicio: isset($data['servicio']) ? [ServicioDTO::fromArray($data['servicio'])] : []
        );
    }
}
