<?php

namespace App\Models;
use App\Http\Requests\CotizacionServicio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionServicio extends Model
{
    use HasFactory;    

    protected $fillable = ['cotizacion_dia_id', 'servicio_id', 'proveedor_id', 'orden', 'hora', 'nombre_servicio', 'observacion', 'tipo_costo_id', 'tipo_habitacion_id', 'precio_id', 'moneda', 'precio_unitario', 'cantidad', 'capacidad', 'subtotal', 'estado_activo'];

    public function dia()
    {
        return $this->belongsTo(CotizacionDia::class, 'cotizacion_dia_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function tipoCosto()
    {
        return $this->belongsTo(TipoCosto::class);
    }

    public function tipoHabitacion()
    {
        return $this->belongsTo(TipoHabitacion::class);
    }

    public function precio()
    {
        return $this->belongsTo(Precio::class);
    }

    /**
     * 🔥 RELACIÓN CLAVE (pivot)
     */
    public function pasajerosPivot()
    {
        return $this->hasMany(CotizacionServicioPasajero::class);
    }

    /**
     * 🔥 RELACIÓN MANY TO MANY (la importante para frontend)
     */
    public function pasajeros() // pivot: cotizacion_servicio_pasajeros, tato
    {
        return $this->belongsToMany(Pasajero::class, 'cotizacion_servicio_pasajeros')
            ->withPivot(['precio', 'cantidad', 'descuento', 'total']);
            //->withTimestamps();
    }

    // public function pasajeros()
    // {
    //     //return $this->belongsToMany(CotizacionServicioPasajero::class);

    //     return $this->belongsToMany(
    //         Pasajero::class,
    //         'cotizacion_servicio_pasajero', // nombre REAL de la tabla pivote
    //         'cotizacion_servicio_id',       // FK local
    //         'pasajero_id'                   // FK relacionada
    //     );

    // }
}
