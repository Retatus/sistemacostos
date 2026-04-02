<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PasajeroResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'temp_id' => $this->temp_id,
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'documento_tipo_id' => $this->documento_tipo_id,
            'documento_numero' => $this->documento_numero,
            'pais_id' => $this->pais_id,
            'documento_file' => $this->documento_file,
            'temp_file_name' => $this->temp_file_name,
            'temp_file_preview' => $this->temp_file_preview,
            'clase_id' => $this->clase_id,
            'cotizacion_id' => $this->cotizacion_id,
            'tipo_pasajero_id' => $this->tipo_pasajero_id,
            'estado_activo' => $this->estado_activo,
        ];
    }
}