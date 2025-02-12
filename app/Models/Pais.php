<?php

namespace App\Models;
use App\Http\Requests\Pais\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($pais) {
                return [
                    'value' => $pais->id,
                    'label' => $pais->nombre,
                ];
            });
    }
}
