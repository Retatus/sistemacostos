<?php

namespace App\Models;
use App\Http\Requests\TipoCosto\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCosto extends Model
{
    use HasFactory;    

    protected $fillable = ['codigo', 'nombre', 'estado_activo'];
}
