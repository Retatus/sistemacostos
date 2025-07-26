<?php

namespace App\DTO;

use App\Models\Cotizacion;

class CotizacionDTO
{
    public function __construct(
        public ?int $id,
        public int $proveedor_id,
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
    ) {}

    public static function createEmpty(): self
    {
        return new self(
            id: 0,
            proveedor_id: 0,
            file_nro: '',
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
            destinos_turisticos: DestinoTuristicoDTO::createEmpty()
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            proveedor_id: $data['proveedor_id'] ?? 0,
            file_nro: $data['file_nro'] ?? Cotizacion::generarCorrelativo(),
            file_nombre: $data['file_nombre'] ?? '',
            comprobante_id: $data['comprobante_id'] ?? 0,
            fecha: $data['fecha'] ?? now()->format('Y-m-d'),
            estado_reserva: $data['estado_reserva'] ?? 0,
            estado_documentacion: $data['estado_documentacion'] ?? 0,
            nro_pasajeros: $data['nro_pasajeros'] ?? 0,
            nro_ninio: $data['nro_ninio'] ?? 0,
            nro_adulto: $data['nro_adulto'] ?? 0,
            nro_estudiante: $data['nro_estudiante'] ?? 0,
            idioma_id: $data['idioma_id'] ?? 0,
            mercado_id: $data['mercado_id'] ?? 0,
            destino_turistico_id: $data['destino_turistico_id'] ?? 0,
            pais_id: $data['pais_id'] ?? 0,
            fecha_inicio: $data['fecha_inicio'] ?? now()->format('Y-m-d'),
            fecha_fin: $data['fecha_fin'] ?? now()->format('Y-m-d'),
            nro_dias: $data['nro_dias'] ?? 1,
            estado_cotizacion: $data['estado_cotizacion'] ?? 0,
            costo_parcial: (float) ($data['costo_parcial'] ?? 0),
            descuento_estudiante: (float) ($data['descuento_estudiante'] ?? 0),
            descuento_ninio: (float) ($data['descuento_ninio'] ?? 0),
            descuento_otro: (float) ($data['descuento_otro'] ?? 0),
            costo_total: (float) ($data['costo_total'] ?? 0),
            estado_activo: $data['estado_activo'] ?? 1,
            destino_turistico_detalle: $data['destino_turistico_detalle'] ?? [],
            destino_turistico_detalle_monto_x_categoria: $data['destino_turistico_detalle_monto_x_categoria'] ?? [],
            destinos_turisticos: isset($data['destinos_turisticos']) 
                ? DestinoTuristicoDTO::fromArray($data['destinos_turisticos']) 
                : null
        );
    }
}
