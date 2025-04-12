<?php

namespace App\Models;
use App\Http\Requests\PasajeroServicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasajeroServicio extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['pasajero_id', 'itinerario_servicio_id', 'estado_activo'];

    public function pasajero()
    {
        return $this->belongsTo(Pasajero::class);
    }

    public function itinerarioServicio()
    {
        return $this->belongsTo(ItinerarioServicio::class, 'itinerario_servicio_id');
    }
}
