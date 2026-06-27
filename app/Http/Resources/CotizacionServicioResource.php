<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CotizacionServicioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'servicio_id' => $this->servicio_id,
            'proveedor_id' => $this->proveedor_id,
            'orden' => $this->orden,
            'hora' => $this->hora,
            'nombre_servicio' => $this->nombre_servicio,
            'observacion' => $this->observacion,
            'tipo_costo_id' => $this->tipo_costo_id,
            'tipo_habitacion_id' => $this->tipo_habitacion_id,
            'precio_id' => $this->precio_id,
            'moneda' => $this->moneda,
            'precio_unitario' => $this->precio_unitario,
            'cantidad' => $this->cantidad,
            'capacidad' => $this->capacidad,
            'subtotal' => $this->monto,
            'estado_activo' => $this->estado_activo,
            'pasajeros' => $this->pasajeros, //->pluck('id'),
            'servicio' => new ServicioResource($this->whenLoaded('servicio', $this->servicio)),
            
        ];
    }
}