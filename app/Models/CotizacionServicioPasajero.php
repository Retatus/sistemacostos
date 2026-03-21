<?php

namespace App\Models;
use App\Http\Requests\CotizacionServicioPasajero\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionServicioPasajero extends Model
{
    use HasFactory;    

    protected $fillable = ['cotizacion_servicio_id', 'pasajero_id', 'precio', 'cantidad', 'descuento', 'total', 'estado_activo'];
}
