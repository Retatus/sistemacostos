<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class HistorialCambio extends Model
{
    protected $table = 'historial_cambios';

    protected $fillable = [
        'entidad',
        'entidad_id',
        'campo',
        'ruta',
        'valor_anterior',
        'valor_nuevo',
        'usuario_id',
        'accion'
    ];

    protected $casts = [
        'valor_anterior' => 'array',
        'valor_nuevo' => 'array',
    ];

}
