<?php

namespace App\Models;
use App\Http\Requests\ProveedorCategoria\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorCategoria extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($categoria) {
                return [
                    'value' => $categoria->id,
                    'label' => $categoria->nombre,
                ];
            });
    }
}
