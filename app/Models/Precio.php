<?php

namespace App\Models;
use App\Http\Requests\Precio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Precio extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['anio', 'moneda', 'monto', 'tipo_pasajero_id', 'servicio_id', 'servicio_clase_id', 'estado_activo'];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id', 'id');
    }

    public function tipo_pasajero()
    {
        return $this->belongsTo(TipoPasajero::class, 'tipo_pasajero_id', 'id');
    }

    public function servicio_clase()
    {
        return $this->belongsTo(ServicioClase::class, 'servicio_clase_id', 'id');
    }

     public static function getFormattedForDropdown($parametro = null)
    {
        return self::orderBy('id', 'desc')
            ->when($parametro, function ($query, $parametro) {
                return $query->where('proveedor_id', $parametro);
            })
            ->get()
            ->map(function ($servicio) {
                return [
                    'value' => $servicio->id,
                    'label' => $servicio->servicio_detalle->descripcion // . ' [' . $servicio->monto . '] ' . $servicio->servicio_detalle->descripcion . ' [' . $servicio->tipo_pax . ']  [' . $servicio->servicio_clase->nombre . ']', // Incluye el nombre de serviciosdetalle en el label
                    //'monto' => $servicio->monto,
                ];
            });
    }
}
