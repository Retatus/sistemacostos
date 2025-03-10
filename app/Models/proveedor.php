<?php

namespace App\Models;
use App\Http\Requests\proveedor\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedor extends Model
{
    use HasFactory;    

    protected $fillable = ['ruc', 'razon_social', 'direccion', 'tipo_comprobante', 'correo', 'tipo_sunat', 'contacto', 'estado_activo', 'proveedor_categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(ProveedorCategoria::class, 'proveedor_categoria_id', 'id');
    }

    public static function getFormattedForDropdown($parametro = null)
    {
        return self::orderBy('id', 'desc')
            ->when($parametro, function ($query, $parametro) {
                return $query->where('proveedor_categoria_id', $parametro);
            })
            ->get()
            ->map(function ($proveedor) {
                return [
                    'value' => $proveedor->id,
                    'label' => $proveedor->ruc . ' - ' . $proveedor->razon_social,
                ];
            });
    }  

    public function desactivar()
    {
        $this->estado_activo = 0;
        return $this->save();
    }
}
