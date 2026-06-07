<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "proveedor_id" => $this->proveedor_id,
            "servicio_detalle_id" => $this->servicio_detalle_id,
            "ubicacion_id" => $this->ubicacion_id,
            "estado_activo" => $this->estado_activo,
            'precios' => PreciosResource::collection(
                $this->whenLoaded('precios', $this->precios)
            ),
            'servicio_detalles' => new ServicioDetallesResource(
                $this->whenLoaded('servicioDetalles', $this->servicioDetalles)
            ),
            'proveedor' => new ProveedorResource($this->whenLoaded('proveedor', $this->proveedor)),
        ];
    }
}
