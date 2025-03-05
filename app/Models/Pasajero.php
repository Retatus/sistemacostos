<?php

namespace App\Models;
use App\Http\Requests\Pasajero\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'documento_tipo_id', 'documento_numero', 'pais_id', 'documento_file', 'tipo_pasajero_id', 'clase_id', 'cotizacion_id', 'estado_activo'];
}
