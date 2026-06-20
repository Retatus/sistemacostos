<?php

namespace App\Services;
use App\Mappers\DestinoToCotizacionMapper;

use App\Models\Cotizacion;
use App\Models\Proveedor;

use App\DTO\CotizacionDTO;
use App\Factory\CotizacionFactory;
use App\Repositories\CotizacionRepository;
use Illuminate\Support\Facades\DB;

class CotizacionServiceApi
{
    protected $destinoService;

    public function __construct(DestinoTuristicoServiceApi $destinoService)
    {
        $this->destinoService = $destinoService;
    }

    public function getDestinosForSelect()
    {
        return $this->destinoService->getDestinosForSelect();
    }

    public function searchDestinos(string $search = null)
    {
        return $this->destinoService->searchDestinos($search);
    }


    public function generarDesdeDestino1($destinoId)
    {
        $destino = $this->destinoService->RecuperarDestinoParaCotizacion($destinoId);

        //dd('destino', Json::encode($destino, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return DestinoToCotizacionMapper::map($destino);
    }

    public function createEmpty(): CotizacionDTO
    {
        return CotizacionFactory::createEmpty();
    }    

    public function generarDesdeDestino($destinoId)
    {
        $cotizacion = CotizacionRepository::DestinoSeleccionado($destinoId);

        //dd('cotizacion', Json::encode($cotizacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return $cotizacion;

        //return DestinoToCotizacionMapper::map($cotizacion);
    }

    public function editarCotizacion($id)
    {
        $cotizacion = CotizacionRepository::EditarCotizacion($id);
        return $cotizacion;
    }
    /**
     * Crear una nueva cotización
     */
    public function create(CotizacionDTO $dto): Cotizacion
    {
        return DB::transaction(function () use ($dto) {

            // 🔥 1. Crear cotización
            $cotizacion = Cotizacion::updateOrCreate(
                ['id' => $dto->id],
                [
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
                ]
            );

            // 🔥 2. Crear pasajeros + MAPEO
            $pasajerosMap = [];

            $idsEnviados = collect($dto->pasajeros)->pluck('id')->filter();

            // ❌ eliminar los que ya no vienen
            // $cotizacion->pasajeros()
            //     ->whereNotIn('id', $idsEnviados)
            //     ->delete();

            $pasajeros = $cotizacion->pasajeros()
                ->whereNotIn('id', $idsEnviados)
                ->get();

            foreach ($pasajeros as $pasajero) {
                $pasajero->delete();
            }

            foreach ($dto->pasajeros as $index => $p) {

                $pasajero = $cotizacion->pasajeros()->updateOrCreate(
                    ['id' => $p->id ?? null],
                    [
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
                    ]
                );

                $pasajerosMap[$index] = $pasajero->id;
            }

            // 🔥 3. Guardar días + servicios + pivot
            $this->syncDias($cotizacion, $dto, $pasajerosMap);

            return $cotizacion->fresh([
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
            $this->syncDias($cotizacion, $dto, []);

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
    private function syncDias(Cotizacion $cotizacion, CotizacionDTO $dto, array $pasajerosMap)
    {
        $idsEnviados = collect($dto->dias)->pluck('id')->filter();

        // ❌ eliminar días que ya no existen
        $cotizacion->dias()
            ->whereNotIn('id', $idsEnviados)
            ->delete();

        foreach ($dto->dias as $diaDTO) {

            $dia = $cotizacion->dias()->updateOrCreate(
                ['id' => $diaDTO->id ?? null],
                [
                    'dia' => $diaDTO->dia,
                    'nombre' => $diaDTO->nombre,
                    'descripcion' => $diaDTO->descripcion,
                ]
            );

            $this->syncServicios($dia, $diaDTO->servicios, $pasajerosMap);
        }
    }     

    private function syncServicios($dia, $serviciosDTO, $pasajerosMap)
    {
        $idsEnviados = collect($serviciosDTO)->pluck('id')->filter();

        // ❌ eliminar los que ya no vienen
        // $dia->servicios()
        //     ->whereNotIn('id', $idsEnviados)
        //     ->delete();

        $servicios = $dia->servicios()
            ->whereNotIn('id', $idsEnviados)
            ->get();

        foreach ($servicios as $servicio) {
            $servicio->delete();
        }

        foreach ($serviciosDTO as $index => $servDTO) {

            $servicio = $dia->servicios()->updateOrCreate(
                ['id' => $servDTO->id ?? null],
                [
                    'servicio_id' => $servDTO->servicio_id,
                    'proveedor_id' => $servDTO->proveedor_id,
                    'orden' => $index + 1, // 🔥 REORDER automático
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
                ]
            );

            // 🔥 PIVOT PASAJEROS
            $servicio->pasajerosPivot()->delete(); // simplificación segura

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