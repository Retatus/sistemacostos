<?php

namespace App\Models;
use App\Http\Requests\TipoHabitacion\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    use HasFactory;    

    protected $fillable = ['id', 'nombre', 'estado_activo'];
}
