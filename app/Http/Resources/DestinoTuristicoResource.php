<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\Json;

class DestinoTuristicoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'pais_id' => $this->pais_id,
            'nro_dias' => $this->nro_dias,
            'costo_total' => $this->costo_total,
            'margen' => $this->margen,
            'ganancia' => $this->ganancia,
            'venta' => $this->venta,
            'estado_activo' => $this->estado_activo,
            'dias' => ItinerarioDestinoResource::collection(
                $this->whenLoaded('dias', $this->itinerarioDestinos)
            ),
        ];
    }
}
