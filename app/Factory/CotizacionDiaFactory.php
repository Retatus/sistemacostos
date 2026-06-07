<?php

namespace App\Factory;

use App\DTO\CotizacionDiaDTO;
use App\Models\CotizacionDia;

use App\Factory\CotizacionServicioFactory;

class CotizacionDiaFactory
{
    public function __construct(
        private CotizacionServicioFactory $servicioFactory,
    ) {}

    public static function createEmpty(): CotizacionDiaDTO
    {
        return new CotizacionDiaDTO(
            id: null,
            dia: 1,
            nombre: '',
            descripcion: '',
            servicios: [] // 🔥 vacío
        );
    }

    public static function fromArray(array $data): CotizacionDiaDTO
    {
        return new CotizacionDiaDTO(
            id: $data['id'] ?? null,
            dia: $data['dia'],
            nombre: $data['nombre'] ?? '',
            descripcion: $data['descripcion'] ?? null,
            servicios: array_map(
                fn($servicio) => CotizacionServicioFactory::fromArray($servicio),
                $data['servicios'] ?? []
            )
        );
    }

    public static function fromModel( CotizacionDia $model): CotizacionDiaDTO
    {
        return new CotizacionDiaDTO(
            id: $model->id,
            dia: $model->dia,
            nombre: $model->nombre,
            descripcion: $model->descripcion,
            servicios: $model->servicios
                ->map(fn($s) => CotizacionServicioFactory::fromModel($s))
                ->toArray(),
        );
    }

    public static function collection(array $items): array
    {
        return array_map(fn($item) => self::fromArray($item), $items);
    }
}
