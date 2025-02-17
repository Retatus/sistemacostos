<?php

namespace App\Models;
use App\Http\Requests\ItinerarioDestino\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioDestino extends Model
{
    use HasFactory;    

    protected $fillable = ['nro_dia', 'itinerario_id', 'destino_turistico_id', 'nombre', 'descripcion', 'observacion', 'estado_activo'];
  
    public function servicios()
    {
        return $this->hasMany(ItinerarioServicio::class, 'itinerario_id', 'itinerario_id');
    }

    public function itinerario()
    {
        return $this->belongsTo(Itinerario::class, 'itinerario_id');
    }
}
