<?php

namespace App\Models;
use App\Http\Requests\Ubicacion\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($ubicacion) {
                return [
                    'value' => $ubicacion->id,
                    'label' => $ubicacion->nombre,
                ];
            });
    }
}
