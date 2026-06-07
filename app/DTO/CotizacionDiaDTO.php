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
}