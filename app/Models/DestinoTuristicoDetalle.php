<?php

namespace App\Models;
use App\Http\Requests\DestinoTuristicoDetalle\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinoTuristicoDetalle extends Model
{
    use HasFactory;    

    protected $fillable = ['nro_dia', 'nombre', 'descripcion', 'estado_activo', 'destino_turistico_id'];

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
