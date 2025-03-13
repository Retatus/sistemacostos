<?php

namespace App\Models;
use App\Http\Requests\ItinerarioServicio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarioServicio extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['nro_orden', 'servicio_id', 'itinerario_destino_id', 'proveedor_categoria_id', 'proveedor_id', 'observacion', 'monto', 'estado_activo'];
}
