<?php

namespace App\Models;
use App\Http\Requests\ServicioDetalle\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioDetalle extends Model
{
    use HasFactory;    

    protected $fillable = ['descripcion', 'costo', 'destino', 'distribucion', 'estado_activo'];
}
