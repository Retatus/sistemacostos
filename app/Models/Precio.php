<?php

namespace App\Models;
use App\Http\Requests\Precio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;    

    protected $fillable = ['anio', 'moneda', 'precio', 'tipo_pasajero_id', 'servicio_id', 'estado_activo'];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id', 'id');
    }
}
