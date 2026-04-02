<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CotizacionDiaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dia' => $this->dia,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,

            'servicios' => CotizacionServicioResource::collection(
                $this->whenLoaded('servicios', $this->servicios)
            ),
        ];
    }
}