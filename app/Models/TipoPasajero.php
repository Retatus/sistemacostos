<?php

namespace App\Models;
use App\Http\Requests\TipoPasajero\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPasajero extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($destino) {
                return [
                    'value' => $destino->id,
                    'label' => $destino->nombre,
                ];
            });
    }
}
