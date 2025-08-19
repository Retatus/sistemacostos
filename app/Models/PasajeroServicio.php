<?php

namespace App\Models;
use App\Http\Requests\PasajeroServicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasajeroServicio extends Model
{
    use HasFactory;    

    //protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['nro_orden', 'hora', 'itinerario_destino_id', 'pasajero_id', 'itinerario_servicio_id', 'cotizacion_id', 'observacion', 'moneda', 'monto', 'estatus','estado_activo'];

    // App/Models/PasajeroServicio.php
    public function itinerarioServicio()
    {
        return $this->belongsTo(ItinerarioServicio::class);
    }

    // public function itinerarioServicio()
    // {
    //     return $this->belongsTo(
    //         ItinerarioServicio::class,   // Modelo relacionado
    //         'itinerario_destino_id',     // Clave foránea en pasajero_servicios
    //         'itinerario_destino_id'      // Clave local en itinerario_servicios
    //     );
    // }

    public function pasajero()
    {
        return $this->belongsTo(Pasajero::class);
    }
}
