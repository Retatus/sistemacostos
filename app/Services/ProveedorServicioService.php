<?php

namespace App\Services;

use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use App\Http\Requests\proveedor\StoreRequest as ProveedorStoreRequest;
use App\Http\Requests\proveedor\UpdateRequest as ProveedorUpdateRequest;
use App\Http\Requests\Servicio\StoreRequest as ServicioStoreRequest;
use App\Http\Requests\Servicio\UpdateRequest as ServicioUpdateRequest;
use App\Http\Requests\Precio\StoreRequest as PrecioStoreRequest;
use App\Http\Requests\Precio\UpdateRequest as PrecioUpdateRequest;
use App\Exceptions\CustomValidationException;
use App\Http\Controllers\PrecioController;
use App\Models\proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;

class ProveedorServicioService
{
    protected $proveedorController;
    protected $servicioController;
    protected $precioController;

    public function __construct(ProveedorController $proveedorController, ServicioController $servicioController, PrecioController $precioController)
    {
        $this->proveedorController = $proveedorController;
        $this->servicioController = $servicioController;
        $this->precioController = $precioController;
    }

    public function handleValidationAndInsertion(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                // **Validar e insertar el proveedor**
                // Validar los datos del proveedor usando las reglas de ProveedorStoreRequest
                $proveedorData = $request->except(['servicios']);
                //dd($proveedorData);
                $validatorProveedor = Validator::make(
                    $proveedorData,
                    (new ProveedorStoreRequest())->rules(),
                    (new ProveedorStoreRequest())->messages()
                );

                if ($validatorProveedor->fails()) {                
                    throw new \Illuminate\Validation\ValidationException($validatorProveedor);
                    //throw new CustomValidationException($validatorProveedor);
                }            
    
                // Llamar al método `store` del controlador de proveedor
                $proveedorResponse = $this->proveedorController->store(new ProveedorStoreRequest($validatorProveedor->validated()));  
                if ($proveedorResponse->getStatusCode() !== 201) {
                    throw new \Exception('Error al insertar proveedor' . json_decode($proveedorResponse->getContent())->data->id);
                } 

                $proveedorId = json_decode($proveedorResponse->getContent())->data->id;
                //dd($proveedorId);
                // **Validar e insertar servicios**
                $detalles = $request->get('servicios', []);
                $precioData = [];
                $servicioData = [];

                foreach ($detalles as $servicioData) {
                    // Añadir `proveedor_id` al servicio
                    $servicioData['proveedor_id'] = $proveedorId;
                    
                    // Validar los datos del servicio usando las reglas de ServicioStoreRequest
                    $validatorServicio = Validator::make(
                        $servicioData,
                        (new ServicioStoreRequest())->rules(),
                        (new ServicioStoreRequest())->messages()
                    );

                    if ($validatorServicio->fails()) {
                        throw new \Illuminate\Validation\ValidationException($validatorServicio);
                        //throw new CustomValidationException($validatorServicio, $proveedorId);
                    }

                    // Llamar al método `store` del controlador de servicio
                    $servicioResponse = $this->servicioController->store(new ServicioStoreRequest($validatorServicio->validated()));   

                    if ($servicioResponse->getStatusCode() !== 201) {
                        throw new \Exception('Error al insertar servicio');
                    }

                    // Verificar si la respuesta no es 201 (Created)
                    if ($servicioResponse->getStatusCode() !== 201) {
                        throw new \Exception(
                            "Error al insertar servicio. Código de estado: " . $servicioResponse->getStatusCode() . ". " .
                            "Respuesta: " . $servicioResponse->getContent()
                        );
                    }

                    $servicioId = json_decode($servicioResponse->getContent())->data->id;

                    $precioData = $servicioData['precios'][0];
                    $precioData['anio'] = date('Y');
                    $precioData['servicio_id'] = $servicioId;

                    $validatorPrecio = Validator::make(
                        $precioData,
                        (new PrecioStoreRequest())->rules(),
                        (new PrecioStoreRequest())->messages()
                    );

                    if ($validatorPrecio->fails()) {
                        throw new \Illuminate\Validation\ValidationException($validatorPrecio);
                        //throw new CustomValidationException($validatorPrecio, $proveedorId);
                    }

                    $precioResponse = $this->precioController->store(new PrecioStoreRequest($validatorPrecio->validated()));

                    if ($precioResponse->getStatusCode() !== 201) {
                        throw new \Exception('Error al insertar precio');
                    }
                }

                return [
                    'proveedor' => $proveedorResponse,           
                    'servicio' => $servicioResponse,
                    'precio' => $precioResponse,
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
        } catch (\Exception $e) {
            // Capturar la excepción y agregar el trace
            throw new \Exception(
                "Error en la creación del servicio: " . $e->getMessage() . "\n" .
                "Trace: " . $e->getTraceAsString()
            );
        }       
    }

    public function handleValidationAndUpdating(Request $request)
    {
    try {
        return DB::transaction(function () use ($request) {
            // Llamar al método `update` del controlador de proveedor para desactivar proveedor anterior
            $proveedorResponseUpdate = $this->proveedorController->updateEstado($request->id);

            // Llamar al método `update` del controlador de servicio para desactivar servicios anteriores
            $servicioResponseUpdate = $this->servicioController->updateEstado($request->id);

            // **Validar e insertar el proveedor**
            // Validar los datos del proveedor usando las reglas de ProveedorStoreRequest
            $proveedorData = $request->except(['servicios']);
            //dd($proveedorData);
            $validatorProveedor = Validator::make(
                $proveedorData,
                (new ProveedorUpdateRequest())->rules(),
                (new ProveedorUpdateRequest())->messages()
            );

            if ($validatorProveedor->fails()) {                
                throw new \Illuminate\Validation\ValidationException($validatorProveedor);
                //throw new CustomValidationException($validatorProveedor);
            }   
            // Llamar al método `store` del controlador de proveedor
            $proveedorResponse = $this->proveedorController->store(new ProveedorStoreRequest($validatorProveedor->validated()));  
            if ($proveedorResponse->getStatusCode() !== 201) {
                throw new \Exception('Error al insertar proveedor' . json_decode($proveedorResponse->getContent())->data->id);
            } 

            $proveedorId = json_decode($proveedorResponse->getContent())->data->id;
            //dd($proveedorId);
            // **Validar e insertar servicios**
            $detalles = $request->get('servicios', []);
            $precioData = [];
            $servicioData = [];

            foreach ($detalles as $servicioData) {
                // Añadir `proveedor_id` al servicio
                $servicioData['proveedor_id'] = $proveedorId;
                
                // Validar los datos del servicio usando las reglas de ServicioStoreRequest
                $validatorServicio = Validator::make(
                    $servicioData,
                    (new ServicioUpdateRequest())->rules(),
                    (new ServicioUpdateRequest())->messages()
                );

                if ($validatorServicio->fails()) {
                    throw new \Illuminate\Validation\ValidationException($validatorServicio);
                    //throw new CustomValidationException($validatorServicio, $proveedorId);
                }

                // Llamar al método `store` del controlador de servicio
                $servicioResponse = $this->servicioController->store(new ServicioStoreRequest($validatorServicio->validated()));

                if ($servicioResponse->getStatusCode() !== 201) {
                    throw new \Exception('Error al insertar servicio');
                }

                // Verificar si la respuesta no es 201 (Created)
                if ($servicioResponse->getStatusCode() !== 201) {
                    throw new \Exception(
                        "Error al insertar servicio. Código de estado: " . $servicioResponse->getStatusCode() . ". " .
                        "Respuesta: " . $servicioResponse->getContent()
                    );
                }

                // Llamar al método `updateEstado` del controlador de precio para desactivar precios anteriores
                $precioResponseUpdate = $this->precioController->updateEstado($servicioData['precios'][0]['servicio_id']);
                
                $servicioId = json_decode($servicioResponse->getContent())->data->id;

                $precioData = $servicioData['precios'][0];
                $precioData['anio'] = date('Y');
                $precioData['servicio_id'] = $servicioId;

                $validatorPrecio = Validator::make(
                    $precioData,
                    (new PrecioUpdateRequest())->rules(),
                    (new PrecioUpdateRequest())->messages()
                );
                //dd($precioData, $validatorPrecio);
                if ($validatorPrecio->fails()) {
                    throw new \Illuminate\Validation\ValidationException($validatorPrecio);
                    //throw new CustomValidationException($validatorPrecio, $proveedorId);
                }

                $precioResponse = $this->precioController->store(new PrecioStoreRequest($validatorPrecio->validated()));

                if ($precioResponse->getStatusCode() !== 201) {
                    throw new \Exception('Error al insertar precio');
                }
            }

            return [
                'proveedorUpdate' => $proveedorResponseUpdate,
                'proveedor' => $proveedorResponse,           
                'servicio' => $servicioResponse,
                'precio' => $precioResponse,
                'message' => 'Proveedor y servicios actualizados correctamente',
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
    } catch (\Exception $e) {
        // Capturar la excepción y agregar el trace
        throw new \Exception(
            "Error en la creación del servicio: " . $e->getMessage() . "\n" .
            "Trace: " . $e->getTraceAsString()
        );
    }
    }  
}
