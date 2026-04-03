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
            'nombre' => $this->servicio->nombre ?? null,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'total' => $this->total,

            'pasajeros' => $this->pasajeros, //->pluck('id'),
        ];
    }
}