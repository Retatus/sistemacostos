<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Proveedor;

class ProveedorApiController extends Controller
{
    public function listProveedores(int $categoria_id)
    {
        $proveedores = Proveedor::where(['proveedor_categoria_id' => $categoria_id, 'escliente' => 0, 'estado_activo' => 1])->orderBy('id', 'desc')->get();
        return response()->json(['proveedores' => $proveedores]);
    }
}
