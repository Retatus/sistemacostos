<?php

namespace App\Models;
use App\Http\Requests\ServicioDetalle\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioDetalle extends Model
{
    use HasFactory;    

    protected $fillable = ['descripcion', 'costo_id', 'destino_id', 'distribucion_venta_id', 'estado_activo'];

    public function costo()
    {
        return $this->belongsTo(Costo::class, 'costo_id', 'id');
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id', 'id');
    }

    public function distribucion_venta()
    {
        return $this->belongsTo(DistribucionVenta::class, 'distribucion_venta_id', 'id');
    }
}
