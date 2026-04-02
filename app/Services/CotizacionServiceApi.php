<?php

namespace App\Services;

use App\Models\Cotizacion;
use App\Models\CotizacionDia;
use App\Models\CotizacionServicio;
use App\Models\Pasajero;
use App\DTO\CotizacionDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Json;

class CotizacionServiceApi
{
    /**
     * Construir una cotización vacía basada en la plantilla del destino
     */
    public function buildFromDestino(int $destinoId): Cotizacion
    {
        //dd('destino_id service', $destinoId);
        $destino = \App\Models\DestinoTuristico::with([
            'itinerarioDestinos.itinerarioServicios.servicio'
        ])->findOrFail($destinoId);

        //dd('destino', $destino->itinerarioDestinos);
        // Cotización temporal (NO se guarda en BD)
        $cotizacion = new Cotizacion([
            'destino_turistico_id' => $destinoId,
            'fecha' => now()->toDateString(),
        ]);
        //dd('cotizacion', $cotizacion);
        // Mapear días desde la plantilla
        $cotizacion->setRelation('dias', $destino->itinerarioDestinos->map(function ($dia) {
            $tmpDia = new CotizacionDia([
                'dia' => $dia->nro_dia,
                'nombre' => $dia->nombre,
                'descripcion' => $dia->descripcion,
            ]);

            // Servicios vacíos (el usuario los agregará)
            $tmpDia->setRelation('servicios', collect());

            return $tmpDia;
        }));
        //dd('cotizacion con dias', $cotizacion);

        // Pasajeros vacíos
        $cotizacion->setRelation('pasajeros', collect());
        return $cotizacion;
    }

    /**
     * Crear una nueva cotización
     */
    public function create(CotizacionDTO $dto): Cotizacion
    {
        return DB::transaction(function () use ($dto) {

            // 🔥 1. Crear cotización
            $cotizacion = Cotizacion::create([
                'id' => $dto->id,
                'proveedor_id' => $dto->proveedor_id,
                'file_nro' => $dto->file_nro,
                'file_nombre' => $dto->file_nombre,
                'comprobante_id' => $dto->comprobante_id,
                'fecha' => $dto->fecha,
                'estado_reserva' => $dto->estado_reserva,
                'estado_documentacion' => $dto->estado_documentacion,
                'nro_pasajeros' => $dto->nro_pasajeros,
                'nro_ninio' => $dto->nro_ninio,
                'nro_adulto' => $dto->nro_adulto,
                'nro_estudiante' => $dto->nro_estudiante,
                'idioma_id' => $dto->idioma_id,
                'mercado_id' => $dto->mercado_id,
                'destino_turistico_id' => $dto->destino_turistico_id,
                'pais_id' => $dto->pais_id,
                'fecha_inicio' => $dto->fecha_inicio,
                'fecha_fin' => $dto->fecha_fin,
                'nro_dias' => $dto->nro_dias,
                'estado_cotizacion' => $dto->estado_cotizacion,
                'costo_parcial' => $dto->costo_parcial,
                'descuento_estudiante' => $dto->descuento_estudiante,
                'descuento_ninio' => $dto->descuento_ninio,
                'descuento_otro' => $dto->descuento_otro,
                'costo_total' => $dto->costo_total,
                'estado_activo' => $dto->estado_activo,
                'destino_turistico_detalle' => $dto->destino_turistico_detalle,
                'destino_turistico_detalle_monto_x_categoria' => $dto->destino_turistico_detalle_monto_x_categoria,
                'destinos_turisticos' => $dto->destinos_turisticos,
            ]);

            // 🔥 2. Crear pasajeros + MAPEO
            $pasajerosMap = [];

            foreach ($dto->pasajeros as $index => $p) {

                $pasajero = $cotizacion->pasajeros()->create([
                    'id' => $p->id,
                    'temp_id' => $p->temp_id,
                    'nombre' => $p->nombre,
                    'apellido_paterno' => $p->apellido_paterno,
                    'apellido_materno' => $p->apellido_materno,
                    'documento_tipo_id' => $p->documento_tipo_id,
                    'documento_numero' => $p->documento_numero,
                    'pais_id' => $p->pais_id,
                    'documento_file' => $p->documento_file,
                    'temp_file_name' => $p->temp_file_name,
                    'temp_file_preview' => $p->temp_file_preview,
                    'clase_id' => $p->clase_id,
                    'tipo_pasajero_id' => $p->tipo_pasajero_id,
                    'estado_activo' => $p->estado_activo,
                ]);

                // 🔥 MAPEO CLAVE
                $pasajerosMap[$index] = $pasajero->id;
            }

            // 🔥 3. Guardar días + servicios + pivot
            $this->saveDias($cotizacion, $dto, $pasajerosMap);

            return $cotizacion->fresh([
                'destino',
                'dias.servicios.pasajeros',
                'pasajeros'
            ]);
        });
    }

    /**
     * Actualizar una cotización existente
     */
    public function update(CotizacionDTO $dto, Cotizacion $cotizacion): Cotizacion
    {
        return DB::transaction(function () use ($dto, $cotizacion) {

            // Actualizar datos principales
            $cotizacion->update([
                'fecha' => $dto->fecha,
            ]);

            // Actualizar pasajeros
            $cotizacion->pasajeros()->delete();
            foreach ($dto->pasajeros as $p) {
                $cotizacion->pasajeros()->create([
                    'nombre' => $p->nombre,
                    'documento' => $p->documento,
                    'edad' => $p->edad,
                ]);
            }

            // Actualizar días y servicios
            $cotizacion->dias()->delete();
            $this->saveDias($cotizacion, $dto, []);

            return $cotizacion->fresh([
                'destino',
                'dias.servicios.pasajeros',
                'pasajeros'
            ]);
        });
    }

    /**
     * Guardar días y servicios (compartido entre create y update)
     */
    private function saveDias(Cotizacion $cotizacion, CotizacionDTO $dto, array $pasajerosMap)
    {
        foreach ($dto->dias as $diaDTO) {

            $dia = $cotizacion->dias()->create([
                'dia' => $diaDTO->dia,
                'nombre' => $diaDTO->nombre,
                'descripcion' => $diaDTO->descripcion,
            ]);

            foreach ($diaDTO->servicios as $servDTO) {

                $servicio = $dia->servicios()->create([
                    'servicio_id' => $servDTO->servicio_id,
                    'proveedor_id' => $servDTO->proveedor_id,
                    'orden' => $servDTO->orden,
                    'hora' => $servDTO->hora,
                    'nombre_servicio' => $servDTO->nombre_servicio,
                    'observacion' => $servDTO->observacion,
                    'tipo_costo_id' => $servDTO->tipo_costo_id,
                    'tipo_habitacion_id' => $servDTO->tipo_habitacion_id,
                    'precio_id' => $servDTO->precio_id,
                    'moneda' => $servDTO->moneda,
                    'precio_unitario' => $servDTO->precio_unitario,
                    'cantidad' => $servDTO->cantidad,
                    'capacidad' => $servDTO->capacidad,
                    'subtotal' => $servDTO->cantidad * $servDTO->precio_unitario,
                    'estado_activo' => $servDTO->estado_activo ?? 1,
                ]);

                // 🔥 PIVOT CON INDEX → ID REAL
                if (!empty($servDTO->pasajeros)) {

                    foreach ($servDTO->pasajeros as $paxData) {
                        $servicio->pasajerosPivot()->create([
                            'pasajero_id' => $pasajerosMap[$paxData->pasajero_index],
                            'precio' => $paxData->precio,
                            'cantidad' => $paxData->cantidad,
                            'descuento' => $paxData->descuento,
                            'total' => $paxData->total,
                        ]);
                    }
                }
            }
        }
    }      
}