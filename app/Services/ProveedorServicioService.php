<?php

namespace App\Services;

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use App\Http\Requests\proveedor\StoreRequest as ProveedorRequest;
use App\Http\Requests\Servicio\StoreRequest as ServicioRequest;
use App\Exceptions\CustomValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        //try {
            return DB::transaction(function () use ($request) {
                // **Validar e insertar el proveedor**
                // Validar los datos del proveedor usando las reglas de ProveedorRequest
                $validatorProveedor = Validator::make(
                    $request->except(['detalles']),
                    (new ProveedorRequest())->rules(),
                    (new ProveedorRequest())->messages()
                );
    
                if ($validatorProveedor->fails()) {                
                    throw new \Illuminate\Validation\ValidationException($validatorProveedor);
                    //throw new CustomValidationException($validatorProveedor);

                }            
    
                // Llamar al método `store` del controlador de proveedor
                $proveedorResponse = $this->proveedorController->store(new ProveedorRequest($validatorProveedor->validated()));
    
                if ($proveedorResponse->getStatusCode() !== 200) {
                    throw new \Exception('Error al insertar proveedor' . json_decode($proveedorResponse->getContent())->id);
                } 
    
                $proveedorId = json_decode($proveedorResponse->getContent())->id;
    
                // **Validar e insertar servicios**
                $detalles = $request->get('detalles', []);
    
                foreach ($detalles as $servicioData) {
                    // Añadir `proveedor_id` al servicio
                    $servicioData['proveedor_id'] = $proveedorId;
    
                    // Validar los datos del servicio usando las reglas de ServicioRequest
                    $validatorServicio = Validator::make(
                        $servicioData,
                        (new ServicioRequest())->rules(),
                        (new ServicioRequest())->messages()
                    );
    
                    if ($validatorServicio->fails()) {
                        throw new \Illuminate\Validation\ValidationException($validatorServicio);
                        //throw new CustomValidationException($validatorServicio, $proveedorId);
                    }
    
                    // Llamar al método `store` del controlador de servicio
                    $servicioResponse = $this->servicioController->store(new ServicioRequest($validatorServicio->validated()));
    
                    if ($servicioResponse->getStatusCode() !== 200) {
                        throw new \Exception('Error al insertar servicio');
                    }
                }
    
                return [
                    
                    'proveedor' => $proveedorResponse,           
                    
                    'message' => 'Proveedor y servicios creados correctamente',
                ];
            });
        // } catch (CustomValidationException $e) {
        //     return response()->json([
        //         'message' => 'Errores de validación',
        //         'errors' => $e->errors(), // Contiene los errores por campo
        //         'index' => $e->getCode() === 0 ? null : $e->getCode(), // Indica el índice en caso de error en un servicio
        //     ], 422);  
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //     ], 500);
        // }        
    }

    public function handleValidationAndUpdating(Request $request)
    {
        // Usar una transacción para asegurar que ambas inserciones sean atómicas.
        return DB::transaction(function () use ($request) {
            $proveedorResponseUpdate = $this->proveedorController->updateEstado($request->id);

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
                'proveedorUpdate' => $proveedorResponseUpdate,
                'proveedor' => $proveedorResponse,                
                'servicio' => $servicioResponse ,
            ];
        });
    }
}
