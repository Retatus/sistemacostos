<?php

namespace App\Services;

use App\Models\Cotizacion;
use Illuminate\Database\Eloquent\Collection;

class CotizacionService
{
    public function getCotizacionWithItinerary(int $cotizacionId): array
    {
        $cotizacion = Cotizacion::with([
            'pasajeros.pasajeroServicios.itinerarioServicio.itinerarioDestino'
        ])->findOrFail($cotizacionId);

        return $this->formatItineraryData($cotizacion);
    }

    protected function formatItineraryData(Cotizacion $cotizacion): array
    {
        $itinerarioPorDia = [];
        
        foreach ($cotizacion->pasajeros as $pasajero) {
            foreach ($pasajero->pasajeroServicios as $pasajeroServicio) {
                $dia = $pasajeroServicio->itinerarioServicio->itinerarioDestino->nro_dia;
                
                if (!isset($itinerarioPorDia[$dia])) {
                    $itinerarioPorDia[$dia] = [
                        'dia' => $dia,
                        'detalle' => []
                    ];
                }
                
                $pasajeroIndex = $this->findPasajeroIndex($itinerarioPorDia[$dia]['detalle'], $pasajero->id);
                $servicioData = $this->formatServicioData($pasajeroServicio->itinerarioServicio);
                
                if ($pasajeroIndex !== null) {
                    $itinerarioPorDia[$dia]['detalle'][$pasajeroIndex]['servicio_detalle'][] = $servicioData;
                } else {
                    $itinerarioPorDia[$dia]['detalle'][] = [
                        'pasajero' => $this->formatPasajeroData($pasajero),
                        'servicio_detalle' => [$servicioData]
                    ];
                }
            }
        }
        
        ksort($itinerarioPorDia);
        return array_values($itinerarioPorDia);
    }

    protected function findPasajeroIndex(array $detalles, int $pasajeroId): ?int
    {
        foreach ($detalles as $index => $detalle) {
            if ($detalle['pasajero']['id'] == $pasajeroId) {
                return $index;
            }
        }
        return null;
    }

    protected function formatServicioData($itinerarioServicio): array
    {
        return [
            'id' => $itinerarioServicio->id,
            'nro_orden' => $itinerarioServicio->nro_orden,
            'servicio_id' => $itinerarioServicio->servicio_id,
            'itinerario_destino_id' => $itinerarioServicio->itinerario_destino_id,
            'proveedor_categoria_id' => $itinerarioServicio->proveedor_categoria_id,
            'proveedor_id' => $itinerarioServicio->proveedor_id,
            'observacion' => $itinerarioServicio->observacion,
            'monto' => number_format($itinerarioServicio->monto, 2),
            'estado_activo' => 1
        ];
    }

    protected function formatPasajeroData($pasajero): array
    {
        return [
            'id' => $pasajero->id,
            'nombre' => $pasajero->nombre,
            'apellido_paterno' => $pasajero->apellido_paterno,
            'apellido_materno' => $pasajero->apellido_materno,
            'documento_tipo_id' => $pasajero->documento_tipo_id,
            'documento_numero' => $pasajero->documento_numero,
            'pais_id' => $pasajero->pais_id,
            'documento_file' => $pasajero->documento_file ?: new \stdClass(),
            'tipo_pasajero_id' => (string)$pasajero->tipo_pasajero_id,
            'clase_id' => $pasajero->clase_id,
            'cotizacion_id' => (string)$pasajero->cotizacion_id,
            'estado_activo' => 1
        ];
    }
}