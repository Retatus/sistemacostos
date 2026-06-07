<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItinerarioServiciosResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "servicio_id" => $this->servicio_id,
            "proveedor_id" => $this->proveedor_id,
            "orden" => $this->nro_orden,
            "hora" => $this->hora.':00',
            //"itinerario_destino_id" => $this->itinerario_destino_id,
            //"proveedor_categoria_id" => $this->proveedor_categoria_id,
            "nombre_servicio"=> $this->observacion,
            "observacion" => $this->observacion,
            "tipo_costo_id" => null, //$this->tipo_costo_id,
            "tipo_habitacion_id" => null, //$this->tipo_habitacion_id,
            "precio_id" => $this->precio_id,
            "moneda" => $this->moneda,
            "precio_unitario" => $this->monto,
            "cantidad" => 1,
            "capacidad" => 1,
            "subtotal" => $this->monto,
            "estado_activo" => $this->estado_activo,
            'servicio' => new ServicioResource($this->whenLoaded('servicio', $this->servicio)),
        ];
    }
}
