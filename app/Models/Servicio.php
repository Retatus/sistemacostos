<?php

namespace App\Models;
use App\Http\Requests\Servicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;    

    protected $fillable = ['proveedor_id', 'servicio_detalle_id', 'ubicacion_id', 'estado_activo'];
    
    public function proveedor()
    {
        return $this->belongsTo(proveedor::class, 'proveedor_id', 'id');
    }

    public function servicio_detalle()
    {
        return $this->belongsTo(ServicioDetalle::class, 'servicio_detalle_id', 'id');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id', 'id');
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
                    'label' => $servicio->moneda . ' [' . $servicio->monto . '] ' . $servicio->servicio_detalle->descripcion . ' [' . $servicio->tipo_pax . ']  [' . $servicio->servicio_clase->nombre . ']', // Incluye el nombre de serviciosdetalle en el label
                    'monto' => $servicio->monto,
                ];
            });
    }  
}
