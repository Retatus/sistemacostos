<?php

namespace App\Models;
use App\Http\Requests\ItinerarioDestino\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioDestino extends Model
{
    use HasFactory;    

    protected $fillable = ['nro_dia', 'itinerario_id', 'destino_turistico_id', 'observacion' => null, 'estado_activo'];
}
