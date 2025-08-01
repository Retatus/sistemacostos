<?php

namespace App\DTO;

use App\Models\Pasajero;

class PasajeroDTO
{
  public function __construct(
    public ?int $id = null,
    public string $temp_id,
    public string $nombre,
    public string $apellido_paterno,
    public string $apellido_materno,
    public int $documento_tipo_id,
    public string $documento_numero,
    public int $pais_id,
    public string $documento_file,
    public string $temp_file_name,
    public string $temp_file_preview,
    public string $tipo_pasajero_id,
    public int $clase_id,    
    public int $cotizacion_id,
    public int $estado_activo = 1,
  ) {}

  public static function createEmpty(): self
  {
    return new self(
      id: null,
      temp_id: '',
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

  public static function fromArray(array $data): self
  {
    return new self(
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
      temp_file_preview: $data['temp_file_preview'] ?? 0,
      clase_id: $data['clase_id'] ?? 0,
      cotizacion_id: $data['cotizacion_id'] ?? 0,
      tipo_pasajero_id: $data['tipo_pasajero_id'] ?? 0,
      estado_activo: $data['estado_activo'] ?? 1,
    );
  }
}