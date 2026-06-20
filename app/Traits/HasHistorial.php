<?php

namespace App\Traits;

use App\Models\HistorialCambio;
use Illuminate\Support\Facades\Auth;

trait HasHistorial
{
    public static function bootHasHistorial()
    {
        static::updated(function ($model) {
            $dirty = $model->getDirty();

            foreach ($dirty as $campo => $nuevoValor) {
                HistorialCambio::create([
                    'entidad'       => class_basename($model),
                    'entidad_id'    => $model->id,
                    'campo'         => $campo,
                    'ruta'          => $campo, // si es JSON anidado, se reemplaza manualmente
                    'valor_anterior'=> $model->getOriginal($campo),
                    'valor_nuevo'   => $nuevoValor,
                    'usuario_id'    => Auth::id(),
                    'accion'        => 'actualizar'
                ]);
            }
        });

        static::created(function ($model) {
            HistorialCambio::create([
                'entidad'       => class_basename($model),
                'entidad_id'    => $model->id,
                'campo'         => '*',
                'ruta'          => null,
                'valor_anterior'=> null,
                'valor_nuevo'   => $model->toArray(),
                'usuario_id'    => Auth::id(),
                'accion'        => 'crear'
            ]);
        });

        static::deleted(function ($model) {
            HistorialCambio::create([
                'entidad'       => class_basename($model),
                'entidad_id'    => $model->id,
                'campo'         => '*',
                'ruta'          => null,
                'valor_anterior'=> $model->toArray(),
                'valor_nuevo'   => null,
                'usuario_id'    => Auth::id(),
                'accion'        => 'eliminar'
            ]);
        });
    }
}

