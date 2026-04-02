<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CotizacionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'proveedor_id' => $this->proveedor_id,
            'file_nro' => $this->file_nro,
            'file_nombre' => $this->file_nombre,
            'comprobante_id' => $this->comprobante_id,
            'fecha' => $this->fecha,
            'estado_reserva' => $this->estado_reserva,
            'estado_documentacion' => $this->estado_documentacion,
            'nro_pasajeros' => $this->nro_pasajeros,
            'nro_ninio' => $this->nro_ninio,
            'nro_adulto' => $this->nro_adulto,
            'nro_estudiante' => $this->nro_estudiante,
            'idioma_id' => $this->idioma_id,
            'mercado_id' => $this->mercado_id,
            'destino_turistico_id' => $this->destino_turistico_id,
            'pais_id' => $this->pais_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'nro_dias' => $this->nro_dias,
            'estado_cotizacion' => $this->estado_cotizacion,
            'costo_parcial' => $this->costo_parcial,
            'descuento_estudiante' => $this->descuento_estudiante,
            'descuento_ninio' => $this->descuento_ninio,
            'descuento_otro' => $this->descuento_otro,
            'costo_total' => $this->costo_total,
            'estado_activo' => $this->estado_activo,

            //?DestinoTuristicoDTO $destinos_turisticos = null,

            'pasajeros' => PasajeroResource::collection(
                $this->whenLoaded('pasajeros', $this->pasajeros)
            ),
            'dias' => CotizacionDiaResource::collection(
                $this->whenLoaded('dias', $this->dias)
            )
        ];
    

        return [
            'id' => $this->id,

            'destino' => $this->whenLoaded('destino', function () {
                return [
                    'id' => $this->destino->id,
                    'nombre' => $this->destino->nombre,
                    'ubicacion' => $this->destino->ubicacion,
                ];
            }),

            'fecha' => $this->fecha,

            'dias' => CotizacionDiaResource::collection(
                $this->whenLoaded('dias', $this->dias)
            ),

            'pasajeros' => PasajeroResource::collection(
                $this->whenLoaded('pasajeros', $this->pasajeros)
            ),

            'totales' => [
                'subtotal' => $this->subtotal ?? 0,
                'impuestos' => $this->impuestos ?? 0,
                'total' => $this->total ?? 0,
            ]
        ];
    }
}