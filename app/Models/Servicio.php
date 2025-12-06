<?php

namespace App\Models;
use App\Http\Requests\Servicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servicio extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];
    
    protected $fillable = ['proveedor_id', 'servicio_detalle_id', 'ubicacion_id', 'estado_activo'];

    // App/Models/Servicio.php
    public function precios()
    {
        return $this->hasMany(Precio::class);
    }

    public function servicioDetalles()
    {
        return $this->belongsTo(ServicioDetalle::class, 'servicio_detalle_id', 'id');
    }

    public function itinerarioServicios()
    {
        return $this->hasMany(ItinerarioServicio::class);
    }

    
    public function proveedor()
    {
        return $this->belongsTo(proveedor::class, 'proveedor_id', 'id');
    }

    public function servicio_detalle()
    {
        return $this->belongsTo(ServicioDetalle::class, 'servicio_detalle_id', 'id');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id', 'id');
    }

    // public function itinerario_servicio_detalle()
    // {
    //     return $this->hasMany(ItinerarioServicio::class, 'servicio_id');
    // }

    public static function getFormattedForDropdownPrecio($parametro = null)
    {
        $precios = DB::table('precios')
            ->join('servicios', 'precios.servicio_id', '=', 'servicios.id')
            ->join('tipo_pasajeros', 'precios.tipo_pasajero_id', '=', 'tipo_pasajeros.id')
            ->join('servicio_detalles', 'servicio_detalles.id', '=', 'servicios.servicio_detalle_id') // Asegúrate de que existe este campo
            //->where('servicios.proveedor_id', $parametro)
            ->when(isset($parametro), function ($q) use ($parametro) {
                return $q->where('servicios.proveedor_id', $parametro);
            })
            ->select('precios.id as precio_id', 'tipo_pasajeros.nombre as tipo_pasajero_nombre', 'precios.moneda', 'precios.monto', 'servicios.id as servicio_id', 'servicio_detalles.descripcion')
            ->get()
            ->map(function ($servicio) {
                return [
                    'value' => $servicio->servicio_id,
                    'label' => $servicio->descripcion . ' [' . $servicio->tipo_pasajero_nombre . ']' . ' [' . $servicio->moneda . ' | ' . $servicio->monto . ']',
                    'moneda' => $servicio->moneda,
                    'monto' => $servicio->monto
                ];
            });
        return $precios;
    }

    public static function getFormattedForDropdown($parametro = null)
    {
        return self::orderBy('id', 'desc')
            ->when($parametro, function ($query, $parametro) {
                return $query->where('proveedor_id', $parametro);
            })
            ->get()
            ->map(function ($servicio) {
                return [
                    'value' => $servicio->id,
                    'label' => $servicio->servicio_detalle->descripcion // . ' [' . $servicio->monto . '] ' . $servicio->servicio_detalle->descripcion . ' [' . $servicio->tipo_pax . ']  [' . $servicio->servicio_clase->nombre . ']', // Incluye el nombre de serviciosdetalle en el label
                    //'monto' => $servicio->monto,
                ];
            });
    }  
}
