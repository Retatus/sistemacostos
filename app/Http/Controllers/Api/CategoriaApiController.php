<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ProveedorCategoria; 

class CategoriaApiController extends Controller
{
    public function index()
    {
        $categoria = ProveedorCategoria::Where('estado_activo', 1)->orderBy('id', 'desc')->get();
        return response()->json( ['categoriaproveedors' => $categoria]);
    }
}
