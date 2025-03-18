<?php

namespace App\Models;
use App\Http\Requests\Idioma\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($idioma) {
                return [
                    'value' => $idioma->id,
                    'label' => $idioma->nombre,
                ];
            });
    }
}
