<?php

namespace App\DTO;

use App\Models\Cotizacion;

class CotizacionDTO
{
    public function __construct(
        public ?int $id,
        public ?int $proveedor_id,
        public string $file_nro,
        public string $file_nombre,
        public int $comprobante_id,
        public string $fecha,
        public int $estado_reserva,
        public int $estado_documentacion,
        public int $nro_pasajeros,
        public int $nro_ninio,
        public int $nro_adulto,
        public int $nro_estudiante,
        public int $idioma_id,
        public int $mercado_id,
        public int $destino_turistico_id,
        public int $pais_id,
        public string $fecha_inicio,
        public string $fecha_fin,
        public int $nro_dias,
        public int $estado_cotizacion,
        public float $costo_parcial,
        public float $descuento_estudiante,
        public float $descuento_ninio,
        public float $descuento_otro,
        public float $costo_total,
        public int $estado_activo,
        public array $destino_turistico_detalle = [],
        public array $destino_turistico_detalle_monto_x_categoria = [],
        public ?DestinoTuristicoDTO $destinos_turisticos = null,
        public array $dias = [],
        public array $pasajeros = []
    ) {}

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            proveedor_id: 0,
            file_nro: Cotizacion::generarCorrelativo(),
            file_nombre: '',
            comprobante_id: 0,
            fecha: now()->format('Y-m-d'),
            estado_reserva: 0,
            estado_documentacion: 0,
            nro_pasajeros: 0,
            nro_ninio: 0,
            nro_adulto: 0,
            nro_estudiante: 0,
            idioma_id: 0,
            mercado_id: 0,
            destino_turistico_id: 0,
            pais_id: 0,
            fecha_inicio: now()->format('Y-m-d'),
            fecha_fin: now()->format('Y-m-d'),
            nro_dias: 1,
            estado_cotizacion: 0,
            costo_parcial: 0.00,
            descuento_estudiante: 0.00,
            descuento_ninio: 0.00,
            descuento_otro: 0.00,
            costo_total: 0.00,
            estado_activo: 1,
            destino_turistico_detalle: [],
            destino_turistico_detalle_monto_x_categoria: [],
            destinos_turisticos: DestinoTuristicoDTO::createEmpty(),
            pasajeros: []
        );
    }
}
