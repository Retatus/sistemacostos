<?php

namespace App\Models;
use App\Http\Requests\DestinoTuristico\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoTuristico extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'descripcion', 'pais_id', 'nro_dias', 'costo_total', 'margen', 'ganancia', 'venta', 'estado_activo'];
    
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function itinerarios() {
        return $this->hasMany(ItinerarioDestino::class, 'destino_turistico_id');
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
