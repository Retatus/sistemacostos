<?php

namespace App\Mappers;

class PreciosMapper
{
    /**
     * Create a new class instance.
     */
    public static function mapPrecios($servicio): array
    {
        return collect($servicio->precios)
            ->sortBy('id')
            ->values()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'descripcion' => self::buildDescripcion($p),
                    'tipo_costo' => $p->tipo_costo,                    
                    'precio' => (float) $p->monto,
                    'moneda' => $p->moneda
                ];
            })->values()->toArray();
    }
   
    private static function buildDescripcion($precio): string
    {
        return match ($precio->tipo_costo) {
            'UNITARIO' => 'PAX',
            'GRUPAL' => 'GRUPO',
            default => $precio->tipo_costo
        };
    }
}
