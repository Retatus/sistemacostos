<?php

namespace App\Models;
use App\Http\Requests\Precio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Precio extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    protected $fillable = ['anio', 'moneda', 'tipo_costo', 'tipo_habitacion', 'pax_min', 'pax_max', 'capacidad_pax', 'monto', 'tipo_pasajero_id', 'servicio_id', 'servicio_clase_id', 'estado_activo'];

    protected $appends = ['tipo_costo_id', 'tipo_habitacion_id'];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id', 'id');
    }

    public function tipo_pasajero()
    {
        return $this->belongsTo(TipoPasajero::class, 'tipo_pasajero_id', 'id');
    }

    public function servicio_clase()
    {
        return $this->belongsTo(ServicioClase::class, 'servicio_clase_id', 'id');
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

    /**
     * Get the tipo_costo_id attribute.
     */
    public function getTipoCostoIdAttribute()
    {
        static $map = null;

        if (!$map) {
            $map = TipoCosto::pluck('id', 'codigo')->toArray();
        }

        return $map[$this->tipo_costo] ?? null;
    }

    /**
     * Get the tipo_habitacion_id attribute.
     */
    public function getTipoHabitacionIdAttribute()
    {
        static $map = null;

        if (!$map) {
            $map = TipoHabitacion::pluck('id', 'nombre')->toArray();
        }

        return $map[$this->tipo_habitacion] ?? null;
    }
}
