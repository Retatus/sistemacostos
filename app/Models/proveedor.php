<?php

namespace App\Models;
use App\Http\Requests\proveedor\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class proveedor extends Model
{
    use HasFactory;    
    
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['ruc', 'tipo_documento_id', 'razon_social', 'direccion', 'tipo_comprobante', 'correo', 'tipo_sunat', 'contacto', 'escliente', 'editado', 'estado_activo', 'proveedor_categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(ProveedorCategoria::class, 'proveedor_categoria_id', 'id');
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'proveedor_id');
    }

    public function catalogoHabitaciones()
    {
        return $this->hasManyThrough(
            Precio::class,
            Servicio::class,
            'proveedor_id',   // FK en servicios
            'servicio_id',    // FK en precios
            'id',             // PK proveedor
            'id'              // PK servicio
        )->where('tipo_costo', 'HABITACION')
        ->selectRaw("
            precios.anio,
            precios.moneda,
            precios.tipo_pasajero_id,
            precios.tipo_habitacion as tipo,
            precios.capacidad_pax as capacidad,
            CAST(precios.monto AS DECIMAL(10,2)) as precio            
        ");
        // CAST(precios.monto AS DECIMAL(10,2)) as precio
    }

    public function catalogoTransportes()
    {
        $precios = $this->catalogoTransportesPuro()->get();

        $transportes = [];

        foreach ($precios as $precio) {
            $tipo = $precio->tipo; // Taxi | Minivan | Sprinter

            if (!isset($transportes[$tipo])) {
                $transportes[$tipo] = [
                    'tipo' => $tipo,
                    'min' => $precio->min,
                    'max' => $precio->max,
                    'capacidad' => $precio->capacidad,
                    'tarifas' => []
                ];
            }

            $transportes[$tipo]['tarifas'][] = [
                'tipo_costo' => $precio->tipo_costo,
                'precio' => (float) $precio->precio,
                'moneda' => $precio->moneda,
                'precio_id' => $precio->id,
                'anio' => $precio->anio,
                'tipo_pasajero_id' => $precio->tipo_pasajero_id,
            ];
        }

        return array_values($transportes);
    }

    public function catalogoTransportesPuro()
    {
        return $this->hasManyThrough(
            Precio::class,
            Servicio::class,
            'proveedor_id',   // FK en servicios
            'servicio_id',    // FK en precios
            'id',             // PK proveedor
            'id'              // PK servicio
        )
        ->where('precios.estado_activo', 1)
        ->whereIn('precios.tipo_costo', ['GRUPAL', 'TRAYECTO', 'HORA', 'DIA'])
        ->select([
            'precios.id',
            'precios.anio',
            'precios.moneda',
            'precios.tipo_pasajero_id',
            'precios.tipo_costo',
            'precios.tipo_habitacion as tipo',
            'precios.pax_min as min',
            'precios.pax_max as max',
            'precios.capacidad_pax as capacidad',
            DB::raw('CAST(precios.monto AS DECIMAL(10,2)) as precio'),
        ]);
    }

    public static function getFormattedForDropdown($parametro = null)
    {
        return self::orderBy('id', 'desc')
            ->when($parametro, function ($query, $parametro) {
                return $query->where('proveedor_categoria_id', $parametro) 
                ->where('estado_activo', 1);
            })
            ->get()
            ->map(function ($proveedor) {
                return [
                    'value' => $proveedor->id,
                    'label' => $proveedor->ruc . ' - ' . $proveedor->razon_social,
                ];
            });
    }  

    public static function findProveedor($tipoDoc, $ruc)
    {
        return self::where('tipo_documento_id', $tipoDoc)
                    ->where('ruc', $ruc)
                    ->where('estado_activo', 1)
                    ->first();
    }  

    public function desactivar()
    {
        $this->estado_activo = 0;
        return $this->save();
    }
}
