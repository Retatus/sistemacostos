<?php

namespace App\DTO;

use App\Models\Cotizacion;

use Illuminate\Http\Request;

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

    public static function fromModel(Cotizacion $model): self
    {
        return new self(
            id: $model->id,
            proveedor_id: $model->proveedor_id,
            file_nro: $model->file_nro,
            file_nombre: $model->file_nombre,
            comprobante_id: $model->comprobante_id,
            fecha: $model->fecha,
            estado_reserva: $model->estado_reserva,
            estado_documentacion: $model->estado_documentacion,            
            nro_pasajeros: $model->nro_pasajeros,
            nro_ninio: $model->nro_ninio,
            nro_adulto: $model->nro_adulto,
            nro_estudiante: $model->nro_estudiante,
            idioma_id: $model->idioma_id,
            mercado_id: $model->mercado_id,
            destino_turistico_id: $model->destino_turistico_id,
            pais_id: $model->pais_id,
            fecha_inicio: $model->fecha_inicio,
            fecha_fin: $model->fecha_fin,
            nro_dias: $model->nro_dias,
            estado_cotizacion: $model->estado_cotizacion,
            costo_parcial: (float) $model->costo_parcial,
            descuento_estudiante: (float) $model->descuento_estudiante,
            descuento_ninio: (float) $model->descuento_ninio,
            descuento_otro: (float) $model->descuento_otro,
            costo_total: (float) $model->costo_total,
            estado_activo: $model->estado_activo,            
            destino_turistico_detalle: $model->destino_turistico_detalle ?? [],
            destino_turistico_detalle_monto_x_categoria: $model->destino_turistico_detalle_monto_x_categoria ?? [],
            destinos_turisticos: isset($model->destinos_turisticos) 
                ? DestinoTuristicoDTO::fromArray($model->destinos_turisticos) 
                : null,
            dias: $model->dias
                ->map(fn($dia) => CotizacionDiaDTO::fromModel($dia))
                ->toArray(),
            pasajeros: $model->pasajeros
                ->map(fn($p) => PasajeroDTO::fromModel($p))
                ->toArray(),
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
                : null,
            dias: array_map(
                fn($dia) => CotizacionDiaDTO::fromArray($dia),
                $data['dias'] ?? []
            ),
            pasajeros: array_map(
                fn($pasajero) => PasajeroDTO::fromArray($pasajero),
                $data['pasajeros'] ?? []
            )
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id') ?? null,
            proveedor_id: $request->input('proveedor_id'),
            file_nro: $request->input('file_nro') ?? Cotizacion::generarCorrelativo(),
            file_nombre: $request->input('file_nombre'),
            comprobante_id: $request->input('comprobante_id'),
            fecha: $request->input('fecha'),
            estado_reserva: $request->input('estado_reserva'),
            estado_documentacion: $request->input('estado_documentacion'),            
            nro_pasajeros: $request->input('nro_pasajeros'),
            nro_ninio: $request->input('nro_ninio'),
            nro_adulto: $request->input('nro_adulto'),
            nro_estudiante: $request->input('nro_estudiante'),
            idioma_id: $request->input('idioma_id'),
            mercado_id: $request->input('mercado_id'),
            destino_turistico_id: $request->input('destino_turistico_id'),
            pais_id: $request->input('pais_id'),
            fecha_inicio: $request->input('fecha_inicio'),
            fecha_fin: $request->input('fecha_fin'),
            nro_dias: $request->input('nro_dias'),
            estado_cotizacion: $request->input('estado_cotizacion'),
            costo_parcial: (float) $request->input('costo_parcial'),
            descuento_estudiante: (float) $request->input('descuento_estudiante'),
            descuento_ninio: (float) $request->input('descuento_ninio'),
            descuento_otro: (float) $request->input('descuento_otro'),
            costo_total: (float) $request->input('costo_total'),
            estado_activo: $request->input('estado_activo'),            
            destino_turistico_detalle: $request->input('destino_turistico_detalle'),
            destino_turistico_detalle_monto_x_categoria: $request->input('destino_turistico_detalle_monto_x_categoria'),
            destinos_turisticos: $request->has('destinos_turisticos') 
                ? DestinoTuristicoDTO::fromArray($request->input('destinos_turisticos')) 
                : null,
            dias: array_map(
                fn($dia) => CotizacionDiaDTO::fromArray($dia),
                $request->input('dias', [])
            ),
            pasajeros: array_map(
                fn($pasajero) => PasajeroDTO::fromArray($pasajero),
                $request->input('pasajeros', [])
            ),          
        );
    }
}
