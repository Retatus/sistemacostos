<?php

namespace App\Models;
use App\Http\Requests\DestinoTuristico\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoTuristico extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'descripcion', 'pais', 'dias', 'costo_total', 'descuento_tipo', 'descuento_estudiante', 'descuento_ninio', 'descuento_otros', 'margen', 'venta', 'estado_activo'];
    
    public function destinoturistico()
    {
        return $this->belongsTo(DestinoTuristico::class, 'destino_turistico_id', 'id');
    }

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($destinoturisticodetalle) {
                return [
                    'value' => $destinoturisticodetalle->id,
                    'label' => $destinoturisticodetalle->nombre,
                ];
            });
    }

    public function desactivar()
    {
        $this->estado_activo = 0;
        return $this->save();
    }
}
