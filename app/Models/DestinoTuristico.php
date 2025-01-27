<?php

namespace App\Models;
use App\Http\Requests\DestinoTuristico\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoTuristico extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'descripcion', 'pais', 'dias', 'costo_total', 'descuento_tipo', 'descuento_estudiante', 'descuento_ninio', 'descuento_otros', 'margen', 'venta', 'estado_activo'];
}
