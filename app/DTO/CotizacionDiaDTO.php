<?php

namespace App\DTO;

class CotizacionDiaDTO
{
    public function __construct(
        public ?int $id,
        public int $dia,
        public ?string $nombre,
        public ?string $descripcion,
        public array $servicios = []
    ) {}

    public static function fromModel($model): self
    {
        return new self(
            id: $model->id,
            dia: $model->dia,
            nombre: $model->nombre,
            descripcion: $model->descripcion,

            servicios: $model->servicios
                ->sortBy('orden')
                ->map(fn($s) => CotizacionServicioDTO::fromModel($s))
                ->values()
                ->toArray()
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            dia: $data['dia'] ?? 0,
            nombre: $data['nombre'] ?? null,
            descripcion: $data['descripcion'] ?? null,
            servicios: isset($data['servicios']) 
                ? array_map(fn($s) => CotizacionServicioDTO::fromArray($s), $data['servicios']) 
                : []
        );
    }
}