<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioDetallesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            "id" => $this->id,
            "descripcion" => $this->descripcion,
            "proveedor_categoria_id" => $this->proveedor_categoria_id,
            "proveedor_categoria" => [
                "id" => $this->proveedor_categoria->id,
                "nombre" => $this->proveedor_categoria->nombre
            ]
        ];
    }
}
