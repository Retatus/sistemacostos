<?php

namespace App\Traits;

use App\Models\HistorialCambio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait HasHistorial
{
    protected static array $schemaCache = [];
    
    public static function bootHasHistorial()
    {
        static::updated(function ($model) {
            //$dirty = $model->getDirty();
            $dirty = collect($model->getDirty())
            ->except([
                'updated_at',
                'created_at',
                'deleted_at',
                'temp_id',
                'temp_file_name',
                'temp_file_preview'
            ])
            ->toArray();

            foreach ($dirty as $campo => $nuevoValor) {

                $valorAnterior = $model->getOriginal($campo);

                if (
                    self::valuesAreEqual(
                        $model,
                        $campo,
                        $valorAnterior,
                        $nuevoValor
                    )
                ) {
                    continue;
                }

                HistorialCambio::create([
                    'entidad'       => class_basename($model),
                    'entidad_id'    => $model->id,
                    'campo'         => $campo,
                    'ruta'          => $campo,
                    'valor_anterior'=> self::normalizeValue(
                        $model,
                        $campo,
                        $valorAnterior
                    ),
                    'valor_nuevo'   => self::normalizeValue(
                        $model,
                        $campo,
                        $nuevoValor
                    ),
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

    private static function getColumnMeta($model, string $field): ?array
    {
        $class = get_class($model);

        if (!isset(self::$schemaCache[$class])) {

            $table = $model->getTable();

            $columns = Schema::getColumns($table);

            self::$schemaCache[$class] = collect($columns)
                ->keyBy('name')
                ->toArray();
        }

        return self::$schemaCache[$class][$field] ?? null;
    }

    private static function normalizeValue($model, string $field, $value)
    {
        if ($value === null) {
            return null;
        }

        $meta = self::getColumnMeta($model, $field);

        if (!$meta) {
            return $value;
        }

        $type = $meta['type_name'] ?? null;

        switch ($type) {

            case 'decimal':

                $scale = $meta['scale'] ?? 2;

                return number_format(
                    (float)$value,
                    $scale,
                    '.',
                    ''
                );

            case 'double':
            case 'float':

                return (float)$value;

            case 'int':
            case 'integer':
            case 'bigint':

                return (int)$value;

            case 'date':

                return \Carbon\Carbon::parse($value)
                    ->format('Y-m-d');

            case 'datetime':
            case 'timestamp':

                return \Carbon\Carbon::parse($value)
                    ->format('Y-m-d H:i:s');

            default:

                return (string)$value;
        }
    }

    private static function valuesAreEqual(
        $model,
        string $field,
        $old,
        $new
    ): bool {

        $oldNormalized =
            self::normalizeValue($model, $field, $old);

        $newNormalized =
            self::normalizeValue($model, $field, $new);

        return $oldNormalized === $newNormalized;
    }
}

