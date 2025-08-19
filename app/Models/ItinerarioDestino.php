<?php

namespace App\Models;
use App\Http\Requests\ItinerarioDestino\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioDestino extends Model
{
    use HasFactory;    
    
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['nro_dia', 'itinerario_id', 'destino_turistico_id', 'nombre', 'descripcion', 'observacion', 'estado_activo'];

    // App/Models/ItinerarioDestino.php
    public function itinerario()
    {
        return $this->belongsTo(Itinerario::class);
    }

    public function itinerarioServicios()
    {
        return $this->hasMany(ItinerarioServicio::class, 'itinerario_destino_id');
    }

    public function destinoTuristico()
    {
        return $this->belongsTo(DestinoTuristico::class);
    }
  
    public function destino_turistico_detalle_servicio()
    {
        return $this->hasMany(ItinerarioServicio::class, 'itinerario_destino_id');
    }
}
