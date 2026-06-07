<?php

namespace App\Factory;

use App\DTO\PasajeroDTO;
use App\Models\Pasajero;

class PasajeroFactory
{
    public function __construct()
    {
        //
    }
    
    public static function createEmpty(): PasajeroDTO
    {
        return new PasajeroDTO(
            id: null,
            temp_id: 0,
            nombre: '',
            apellido_paterno: '',
            apellido_materno: '',
            documento_tipo_id: 0,
            documento_numero: '',
            pais_id: 0,
            documento_file: '',
            temp_file_name: '',
            temp_file_preview: '',
            clase_id: 0,
            cotizacion_id: 0,
            tipo_pasajero_id: 0,
            estado_activo: 1,
        );
    }

    public static function fromArray(array $data): PasajeroDTO
    {
        return new PasajeroDTO(
            id: $data['id'] ?? null,
            temp_id: $data['temp_id'] ?? 0,
            nombre: $data['nombre'] ?? '',
            apellido_paterno: $data['apellido_paterno'] ?? '',
            apellido_materno: $data['apellido_materno'] ?? '',
            documento_tipo_id: $data['documento_tipo_id'] ?? 0,
            documento_numero: $data['documento_numero'] ?? '',
            pais_id: $data['pais_id'] ?? 0,
            documento_file: $data['documento_file'] ?? '',
            temp_file_name: $data['temp_file_name'] ?? '',
            temp_file_preview: $data['temp_file_preview'] ?? '',
            clase_id: $data['clase_id'] ?? 0,
            cotizacion_id: $data['cotizacion_id'] ?? 0,
            tipo_pasajero_id: $data['tipo_pasajero_id'] ?? 0,
            estado_activo: $data['estado_activo'] ?? 1,
        );
    }

    public static function fromModel(Pasajero $model): PasajeroDTO
    {
        return new PasajeroDTO(
            id: $model->id,
            temp_id: $model->temp_id,
            nombre: $model->nombre,
            apellido_paterno: $model->apellido_paterno,
            apellido_materno: $model->apellido_materno,
            documento_tipo_id: $model->documento_tipo_id,
            documento_numero: $model->documento_numero,
            pais_id: $model->pais_id,
            documento_file: $model->documento_file,
            temp_file_name: $model->temp_file_name,
            temp_file_preview: $model->temp_file_preview,
            clase_id: $model->clase_id,
            cotizacion_id: $model->cotizacion_id,
            tipo_pasajero_id: $model->tipo_pasajero_id,
            estado_activo: $model->estado_activo,
        );
    }
}
