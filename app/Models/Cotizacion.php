<?php

namespace App\Models;
use App\Http\Requests\Cotizacion\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;    

    protected $fillable = ['proveedor_id', 'file_nro', 'file_nombre', 'comprobante_id', 'fecha', 'nro_pasajeros', 'nro_ninio', 'nro_adulto', 'nro_estudiante', 'idioma_id', 'mercado_id', 'destino_turistico_id', 'pais_id', 'fecha_inicio', 'fecha_fin', 'nro_dias', 'estado_cotizacion', 'costo_parcial', 'descuento_estudiante', 'descuento_ninio', 'descuento_otro', 'costo_total', 'estado_activo'];

    public function tipo_comprobante()
    {
        return $this->belongsTo(TipoComprobante::class, 'comprobante_id', 'id');
    }
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }
    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'idioma_id', 'id');
    }
    public function mercado()
    {
        return $this->belongsTo(Mercado::class, 'mercado_id', 'id');
    }

    public static function getFormattedForDropdown()
    {
        return self::orderBy('id', 'desc')
            ->get()
            ->map(function ($costos) {
                return [
                    'value' => $costos->id,
                    'label' => $costos->file_nro . ' - ' . $costos->file_nombre,
                ];
            });
    }
    public static function generarCorrelativo()
    {
        $ultimoCorrelativo = Cotizacion::latest('file_nro')->first()->file_nro ?? '0001';

        // Extraer el número correlativo (primeros 4 dígitos)
        $numero = substr($ultimoCorrelativo, 0, 4);

        // Incrementar el número correlativo
        $nuevoNumero = str_pad((int) $numero + 1, 4, '0', STR_PAD_LEFT);

        // Obtener el mes y el año actual
        $mes = now()->format('m'); // Mes en formato MM
        $anio = now()->format('Y'); // Año en formato YYYY

        // Combinar el nuevo número con el mes y el año
        $nuevoCorrelativo = $nuevoNumero . $mes . $anio;

        return $nuevoCorrelativo;
    }
}
