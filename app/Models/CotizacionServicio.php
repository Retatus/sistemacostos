<?php

namespace App\Models;
use App\Http\Requests\CotizacionServicio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionServicio extends Model
{
    use HasFactory;    

    protected $fillable = ['cotizacion_id', 'cotizacion_dia_id', 'servicio_id', 'proveedor_id', 'orden', 'hora', 'nombre_servicio', 'observacion', 'tipo_costo_id', 'tipo_habitacion_id', 'precio_id', 'moneda', 'precio_unitario', 'cantidad', 'capacidad', 'subtotal', 'estado_activo'];
}
