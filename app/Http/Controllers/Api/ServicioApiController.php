<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mappers\ItinerarioServicioMapper;
use App\Models\Servicio;
use App\Models\ServicioDetalle;
use App\Repositories\ServicioRepository;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class ServicioApiController extends Controller
{
    public function listServicios(int $proveedor_id)
    {
        $servicios = ServicioRepository::Servicios($proveedor_id);
        return response()->json(['servicios' => $servicios]);
    }
    
    public function getServicio(int $id)
    {
        $servicio = ServicioRepository::Servicio($id);
        return response()->json(['servicio' => $servicio]);
    }
}
