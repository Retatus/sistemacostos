<?php

namespace App\Models;
use App\Http\Requests\CotizacionDia\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionDia extends Model
{
    use HasFactory;    

    protected $fillable = ['cotizacion_id', 'dia', 'nombre', 'descripcion', 'estado_activo'];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
    
    public function servicios()
    {
        return $this->hasMany(CotizacionServicio::class, 'cotizacion_dia_id');
    }
}
