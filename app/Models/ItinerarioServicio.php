<?php

namespace App\Models;
use App\Http\Requests\ItinerarioServicio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioServicio extends Model
{
    use HasFactory;    

    protected $fillable = ['nro_orden', 'servicio_id', 'itinerario_id', 'observacion', 'estado_activo'];
}
