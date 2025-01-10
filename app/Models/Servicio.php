<?php

namespace App\Models;
use App\Http\Requests\Servicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;    

    protected $fillable = ['tipo_pax', 'moneda', 'proveedor_id', 'servicio_detalle_id', 'ubicacion', 'servicio_clase_id'];

    public function proveedor()
    {
        return $this->belongsTo(proveedor::class, 'proveedor_id', 'id');
    }

    public function servicio_detalle()
    {
        return $this->belongsTo(ServicioDetalle::class, 'servicio_detalle_id', 'id');
    }

    public function servicio_clase()
    {
        return $this->belongsTo(ServicioClase::class, 'servicio_clase_id', 'id');
    }
}
