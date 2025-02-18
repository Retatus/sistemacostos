<?php

namespace App\Models;
use App\Http\Requests\Servicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;    

    protected $fillable = ['monto', 'moneda', 'proveedor_id', 'servicio_detalle_id', 'ubicacion', 'tipo_pax', 'servicio_clase_id', 'estado_activo'];
    
    public function proveedor()
    {
        return $this->belongsTo(proveedor::class, 'proveedor_id', 'id');
    }

    public function servicio_detalle()
    {
        return $this->belongsTo(ServicioDetalle::class, 'servicio_detalle_id', 'id');
    }

    public function servicio_clase()
    {
        return $this->belongsTo(ServicioClase::class, 'servicio_clase_id', 'id');
    }

    public static function getFormattedForDropdown($parametro = null)
    {
        // return self::select('servicios.id', 'servicios.moneda', 'servicios.monto', 'servicios.tipo_pax', 'servicios.servicio_clase_id', 'servicio_detalles.descripcion as servicio_detalle_nombre')
        //     ->join('servicio_detalles', 'servicios.servicio_detalle_id', '=', 'servicio_detalles.id') // INNER JOIN con servicio_detalles
        //     ->orderBy('servicios.id', 'desc') // Ordenar por el ID de servicios
        //     ->when($parametro, function ($query, $parametro) {
        //         return $query->where('servicios.proveedor_id', $parametro); // Filtro por proveedor_id
        //     })
        //     ->get()
        //     ->map(function ($servicio) {
        //         return [
        //             'value' => $servicio->id,
        //             'label' => $servicio->moneda . ' [ ' . $servicio->monto . ' ] ' . $servicio->servicio_detalle_nombre . ' ' . $servicio->tipo_pax . ' [ ' . $servicio->servicio_clase->nombre . ' ]', // Incluye el nombre de serviciosdetalle en el label
        //         ];
        //     });

        return self::orderBy('id', 'desc')
            ->when($parametro, function ($query, $parametro) {
                return $query->where('proveedor_id', $parametro);
            })
            ->get()
            ->map(function ($servicio) {
                return [
                    'value' => $servicio->id,
                    'label' => $servicio->moneda . ' [' . $servicio->monto . '] ' . $servicio->servicio_detalle->descripcion . ' [' . $servicio->tipo_pax . ']  [' . $servicio->servicio_clase->nombre . ']', // Incluye el nombre de serviciosdetalle en el label
                    'monto' => $servicio->monto,
                ];
            });
    }  
}
