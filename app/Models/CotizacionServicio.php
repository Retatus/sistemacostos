<?php

namespace App\Models;
use App\Http\Requests\CotizacionServicio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionServicio extends Model
{
    use HasFactory;    

    protected $fillable = ['nro_dia', 'nro_orden', 'hora', 'itinerario_servicio_id', 'cotizacion_id', 'precio_id', 'moneda', 'precio_unitario', 'cantidad', 'capacidad', 'tipo_habitacion', 'subtotal', 'observacion',  'tipo_costo_id', 'estado_activo'];
}
