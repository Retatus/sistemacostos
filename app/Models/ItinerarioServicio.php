<?php

namespace App\Models;
use App\Http\Requests\ItinerarioServicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioServicio extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['nro_orden', 'hora', 'itinerario_servicio_id', 'servicio_id', 'itinerario_destino_id', 'proveedor_categoria_id', 'proveedor_id', 'observacion', 'moneda', 'monto', 'estado_activo'];

    // App/Models/ItinerarioServicio.php
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function itinerarioDestino()
    {
        return $this->belongsTo(ItinerarioDestino::class, 'itinerario_destino_id');
    }

    // public function pasajeroServicios()
    // {
    //     return $this->hasMany(
    //         PasajeroServicio::class, 
    //         'itinerario_destino_id', 
    //         'itinerario_destino_id'
    //     ); //->whereColumn('pasajero_servicios.nro_orden', 'itinerario_servicios.nro_orden');
    //         //->groupby('nro_orden');
    // }

    public function pasajeroServicios()
    {
        return $this->hasMany(PasajeroServicio::class);
    }
    
    // public function itinerarioDestino()
    // {
    //     return $this->belongsTo(ItinerarioDestino::class, 'itinerario_destino_id');
    // }

    // public function servicio()
    // {
    //     return $this->belongsTo(ItinerarioDestino::class, 'servicio_id');
    // }

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($itinerarioServicio) {
                return [
                    'value' => $itinerarioServicio->id,
                    'label' => $itinerarioServicio->observacion,
                ];
            });
    }
}
