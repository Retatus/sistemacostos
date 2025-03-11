<?php

namespace App\Models;
use App\Http\Requests\Mercado\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($mercado) {
                return [
                    'value' => $mercado->id,
                    'label' => $mercado->nombre,
                ];
            });
    }
}
