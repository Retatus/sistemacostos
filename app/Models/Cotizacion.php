<?php

namespace App\Models;
use App\Http\Requests\Cotizacion\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;    

    protected $fillable = ['proveedor_id', 'file_nro', 'file_nombre', 'comprobante_id', 'fecha', 'nro_pasajeros', 'nro_ninio', 'nro_adulto', 'nro_estudiante', 'idioma', 'mercado', 'destino_turistico_id', 'pais_id', 'fecha_inicio', 'fecha_fin', 'nro_dias', 'estado_cotizacion', 'costo_parcial', 'descuento_estudiante', 'descuento_ninio', 'descuento_otro', 'costo_total', 'estado_activo'];

    public static function generarCorrelativo()
    {
        $mes = date('m'); // Obtiene el mes actual (02 para febrero)
        $anio = date('Y'); // Obtiene el año actual (2025)

        // Obtener el último correlativo registrado en la base de datos
        $ultimo = Cotizacion::latest('id')->first();

        $numero = $ultimo ? intval(substr($ultimo->correlativo, 0, 4)) + 1 : 1;

        // Formatear el número a 4 dígitos y concatenar mes y año
        $correlativo = str_pad($numero, 4, '0', STR_PAD_LEFT) . $mes . $anio;

        return $correlativo;
    }
}
