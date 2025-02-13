<?php

namespace App\Models;
use App\Http\Requests\TipoPasajero\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPasajero extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];
}
