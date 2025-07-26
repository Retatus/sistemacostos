<?php

namespace App\DTO;

class DestinoTuristicoDTO
{
    public function __construct(
        public ?int $id,
        public string $nombre,
        public string $descripcion,
        public int $pais_id,
        public int $nro_dias,
        public string $costo_total,
        public float $margen,
        public string $ganancia,
        public string $venta,
        public int $estado_activo,
        public array $itinerario_destinos = [], // Lista de ItinerarioDestinoDTO
    ) {}

    public static function createEmpty(): self
    {
        return new self(
            id: null,
            nombre: '',
            descripcion: '',
            pais_id: 0,
            nro_dias: 0,
            costo_total: '0.00',
            margen: 0.0,
            ganancia: '0.00',
            venta: '0.00',
            estado_activo: 1,
            itinerario_destinos: [ItinerarioDestinoDTO::createEmpty()] // Assuming this is a single DTO, not a collection
        );
    }



    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            nombre: $data['nombre'] ?? '',
            descripcion: $data['descripcion'] ?? '',
            pais_id: $data['pais_id'] ?? 0,
            nro_dias: $data['nro_dias'] ?? 0,
            costo_total: $data['costo_total'] ?? '0.00',
            margen: $data['margen'] ?? 0.0,
            ganancia: $data['ganancia'] ?? '0.00',
            venta: $data['venta'] ?? '0.00',
            estado_activo: $data['estado_activo'] ?? 1,
            itinerario_destinos: [ItinerarioDestinoDTO::fromArray($data['itinerario_destinos'] ?? [])]
        );
    }

}
