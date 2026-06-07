<?php

namespace App\Repositories;

use App\Models\DestinoTuristico;

class DestinoTuristicoRepository
{
    public function getAllForSelect()
    {
        return DestinoTuristico::select('id', 'nombre')
            ->where('estado_activo', 1)
            ->orderBy('nombre')
            ->get();
    }

    public function searchForAutocomplete(?string $search = null, int $perPage = 10)
    {
        return DestinoTuristico::select('id', 'nombre')
            ->where('estado_activo', 1)
            ->when($search, function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })
            ->orderBy('nombre')
            ->paginate($perPage);
    }


    public static function DestinoSeleccionado(int $destinoId)
    {
        $destino = DestinoTuristico::with([
            'itinerarioDestinos' => function($query) {
                $query->with([
                    'itinerario',
                    'itinerarioServicios' => function($query) {
                        $query->with([
                            'servicio' => function($query) {
                                $query->with([
                                    'precios',
                                    'servicioDetalles' => function($query) {
                                        $query->select('id', 'descripcion', 'proveedor_categoria_id') // Incluye la clave foránea
                                            ->with([
                                                'proveedor_categoria' => function($query) {
                                                    $query->select('id', 'nombre'); // Solo los campos necesarios
                                                }
                                            ]);
                                    },
                                    'proveedor' => function($query) {
                                        $query->select('id', 'ruc', 'razon_social', 'proveedor_categoria_id')
                                            //->where('proveedor_categoria_id', 2) // unicamente categorias de hoteles
                                            ->with('catalogoHabitaciones');
                                            //->with('catalogoTransportes');
                                    }
                                ]);
                            },
                            //'pasajeroServicios.pasajero' // Nueva relación añadida
                        ]);
                    }
                ]);
            }
        ])->find($destinoId);

        return $destino;
    }
}
