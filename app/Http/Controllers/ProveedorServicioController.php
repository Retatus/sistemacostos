<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\proveedor\StoreRequest as ProveedorRequest;
use App\Http\Requests\Servicio\StoreRequest as ServicioRequest;
use App\Services\ProveedorServicioService;

class ProveedorServicioController extends Controller
{
    protected $service;

    public function __construct(ProveedorServicioService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return "hola";
    }

    public function store(Request $request)
    {
        try {
            $result = $this->service->handleValidationAndInsertion($request);

            return response()->json([
                'message' => 'Proveedor y servicio creados exitosamente',
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function update(Request $request, $proveedor_servicio)
    {
        try {
            $result = $this->service->handleValidationAndUpdating($request);

            return response()->json([
                'message' => 'Proveedor y servicio creados exitosamente',
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
