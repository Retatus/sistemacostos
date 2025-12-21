<?php

namespace App\Models;
use App\Http\Requests\Pasajero\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    use HasFactory;    

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['temp_id', 'nombre', 'apellido_paterno', 'apellido_materno', 'documento_tipo_id', 'documento_numero', 'pais_id', 'documento_file', 'tipo_pasajero_id', 'clase_id', 'cotizacion_id', 'estado_activo'];

    // App/Models/Pasajero.php
    public function pasajeroServicios()
    {
        return $this->hasMany(PasajeroServicio::class, 'cotizacion_id', 'cotizacion_id');
    }

    public function tipo_docuemento()
    {
        return $this->belongsTo(TipoDocumento::class, 'documento_tipo_id', 'id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function tipo_pasajero()
    {
        return $this->belongsTo(TipoPasajero::class, 'tipo_pasajero_id', 'id');
    }

    public function tipo_clase()
    {
        return $this->belongsTo(ServicioClase::class, 'clase_id', 'id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($pasajero) {
                return [
                    'value' => $pasajero->id,
                    'label' => $pasajero->nombre.' '.$pasajero->apellido_paterno.' '.$pasajero->apellido_materno,
                ];
            });
    }

    public static function findPasajero($tipoDoc, $nroDoc)
    {
        return self::where('documento_tipo_id', $tipoDoc)
                    ->where('documento_numero', $nroDoc)
                    ->where('estado_activo', 1)
                    ->first();
    }  
}
