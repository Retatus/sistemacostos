<?php

namespace App\Models;
use App\Http\Requests\Itinerario\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'descripcion', 'duracion', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($itinerario) {
                return [
                    'value' => $itinerario->id,
                    'label' => $itinerario->nombre,
                    'descripcion' => $itinerario->descripcion,
                ];
            });
    }
}
