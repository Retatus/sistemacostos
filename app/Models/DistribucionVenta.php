<?php

namespace App\Models;
use App\Http\Requests\DistribucionVenta\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribucionVenta extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($distribucion) {
                return [
                    'value' => $distribucion->id,
                    'label' => $distribucion->nombre,
                ];
            });
    }
}
