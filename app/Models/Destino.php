<?php

namespace App\Models;
use App\Http\Requests\Destino\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;    

    protected $fillable = ['codigo', 'nombre', 'estado_activo'];
}
