<?php

namespace App\DTO;

use App\Models\Itinerario;

class ItinerarioDestinoDTO
{
    public function __construct(
        public int $id,
        public int $nro_dia,
        public int $itinerario_id,
        public int $destino_turistico_id,
        public string $nombre,
        public string $descripcion,
        public string $observacion,
        public int $estado_activo,
        public ?ItinerarioDTO $itinerario,
        public array $itinerario_servicios = [], // Lista de ServicioDTO
    ) {}

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            nro_dia: 0,
            itinerario_id: 0,
            destino_turistico_id: 0,
            nombre: '',
            descripcion: '',
            observacion: '',
            estado_activo: 1,
            itinerario: ItinerarioDTO::createEmpty(),
            itinerario_servicios: [ItinerarioServicioDTO::createEmpty()] // Assuming this is a single DTO, not a collection
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            nro_dia: $data['nro_dia'] ?? 0,
            itinerario_id: $data['itinerario_id'] ?? 0,
            destino_turistico_id: $data['destino_turistico_id'] ?? 0,
            nombre: $data['nombre'] ?? '',
            descripcion: $data['descripcion'] ?? '',
            observacion: $data['observacion'] ?? '',
            estado_activo: $data['estado_activo'] ?? 1,
            itinerario: ItinerarioDTO::fromArray($data['itinerario'] ?? []),
            itinerario_servicios: [ItinerarioServicioDTO::fromArray($data['itinerario_servicios'] ?? [])]
        );
    }
}
