<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItinerarioDestinoResource extends JsonResource
{   
    public function toArray($request)
    {
        return [ 
            'id' => $this->id,
            'dia' => $this->nro_dia,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'servicios' => ItinerarioServiciosResource::collection(
                $this->whenLoaded('servicios', $this->servicios)
            ),
        ];
    }
}
