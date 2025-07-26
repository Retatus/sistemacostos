<?php
namespace App\DTO;

class ItinerarioDTO
{
    public function __construct(
        public int $id,
        public string $nombre,
        public string $descripcion,
        public string $duracion,
        public int $estado_activo

    ) {}

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            nombre: '',
            descripcion: '',
            duracion: '0',
            estado_activo: 1
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            nombre: $data['nombre'] ?? '',
            descripcion: $data['descripcion'] ?? '',
            duracion: $data['duracion'] ?? '0',
            estado_activo: $data['estado_activo'] ?? 1
        );
    }
}
