<?php

namespace App\Models;
use App\Http\Requests\ModoCobro\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModoCobro extends Model
{
    use HasFactory;    

    protected $fillable = ['codigo', 'nombre', 'requiere_cantidad', 'requiere_habitacion', 'estado_activo'];
}
