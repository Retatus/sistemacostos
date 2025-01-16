<?php

namespace App\Services;

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorServicioService
{
    protected $proveedorController;
    protected $servicioController;

    public function __construct(ProveedorController $proveedorController, ServicioController $servicioController)
    {
        $this->proveedorController = $proveedorController;
        $this->servicioController = $servicioController;
    }

    public function handleValidationAndInsertion(Request $request)
    {
        // Usar una transacción para asegurar que ambas inserciones sean atómicas.
        return DB::transaction(function () use ($request) {
            // Validar e insertar proveedor
            $proveedor = new Request($request->except(['detalles','costo','destino']));
            $proveedorResponse = $this->proveedorController->store($proveedor);

            // Obtener el ID del proveedor creado
            $proveedorId = json_decode($proveedorResponse->getContent())->id;
            // if ($proveedorResponse->getStatusCode() !== 200) {
            //     throw new \Exception('Error al insertar proveedor' .$proveedorId);
            // }          
            
            $detalles = $request->only('detalles')['detalles'];
           
            foreach ($detalles as $servicio) {
                $servicio['proveedor_id'] = $proveedorId;
                $servicioRequest = new Request($servicio);
                $servicioResponse = $this->servicioController->store($servicioRequest);
                // if ($servicioResponse->getStatusCode() !== 200) {
                //     throw new \Exception('Error al insertar servicio');
                // }
            }
            return [
                'proveedor' => $proveedorResponse,                
                'servicio' => $servicioResponse ,
            ];
        });
    }
}
