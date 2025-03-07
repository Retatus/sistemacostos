<?php

namespace App\Models;
use App\Http\Requests\Precio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;    

    protected $fillable = ['anio', 'moneda', 'monto', 'tipo_pasajero_id', 'servicio_id', 'servicio_clase_id', 'estado_activo'];

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
}
