<?php

namespace App\Models;
use App\Http\Requests\ServicioClase\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioClase extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];
    
}
