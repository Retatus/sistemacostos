<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CotizacionServicioPasajeroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */    

    public function toArray($request)
    {
        return [
            'pasajero_id' => $this->pasajero_id,
            'precio' => (float)($this->precio ?? 0),
            'cantidad' => (int)($this->cantidad ?? 1),
            'descuento' => (float)($this->descuento ?? 0),
            'total' => (float)($this->total ?? 0),
        ];
    }
}
