<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestinoTuristico\DestinoTuristicoRequest;
use App\Http\Requests\DestinoTuristico\StoreRequest;
use App\Models\DestinoTuristico;
use App\Models\Itinerario;
use App\Models\ItinerarioDestino;
use App\Models\ItinerarioServicio;
use App\Models\Pais;
use App\Models\proveedor;
use App\Models\ProveedorCategoria;
use App\Models\Servicio;
use App\Models\ServicioClase;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
class DestinoTuristicoController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinoturisticos = DestinoTuristico::with('pais:id,nombre')
        ->where('estado_activo', 1)
        ->orderBy('id', 'desc')
        ->get(); // Ordenar por ID descendente
        //dd($destinoturisticos);
        return Inertia::render('DestinoTuristico/Index', compact('destinoturisticos'));
        //return response()->json( ['destinoturistico' => $destinoturistico]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return Inertia::render('DestinoTuristico/Create');
        $formattedPaises = Pais::getFormattedForDropdown();
        $formattedItinerarios = Itinerario::getFormattedForDropdown();
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedProveedores = proveedor::getFormattedForDropdown();
        // $formattedCostos = Costo::getFormattedForDropdown();
        // $formattedDestinos = Destino::getFormattedForDropdown();
        // $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        $formattedServicio = Servicio::getFormattedForDropdown();
        $formattedServicioClase = ServicioClase::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('DestinoTuristico/CreateDestinoTuristico', 
        [
            'ListaPaises' => $formattedPaises,
            'ListaItinerarios' => $formattedItinerarios,
            'ListaProveedorCategorias' => $formattedCategorias,
            'ListaProveedor' =>  $formattedProveedores,
            // 'categoriaDestinos' => $formattedDestinos,
            // 'categoriaDistribuciones' => $formattedDistribuciones,
            'ListaServicio' => $formattedServicio,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinoTuristicoRequest $request)
    {
        // $data = $request->all(); 
        // $destino_turistico = $request->except(['destino_turistico_detalle']);
        // $destino_turistico_detalle = $request->get('destino_turistico_detalle', []);
        // dd($destino_turistico_detalle, $destino_turistico);
        // DestinoTuristico::create($destino_turistico);
        // return to_route('destino_turistico');
        
        return DB::transaction(function () use ($request) {
            // SECCION DESTINO TURISTICO
            $destinoTuristico = $request->except(['destino_turistico_detalle', 'destino_turistico_detalle_servicio']);
            $destinoTuriaticoResponse = DestinoTuristico::create($destinoTuristico);
            //$destinoTuriaticoResponse = $this->itinerario_destino->store($destinoTuristico);

            // if ($destinoTuriaticoResponse->getStatusCode() !== 200) {
            //     throw new \Exception('Error al insertar destinoTuristico' . json_decode($destinoTuriaticoResponse->getContent())->id);
            // } 

            // $destinoTuristicoId = json_decode($destinoTuriaticoResponse->getContent())->id;
            $destinoTuristicoId = $destinoTuriaticoResponse->id;

            // SECCION ITINERARIO DESTINO
            $destino_turistico_detalle = $request->get('destino_turistico_detalle', []);

            foreach ($destino_turistico_detalle as $itinerarioDestinoData) {
                // Añadir `destino_turistico_id` al itinerarioDestino
                $itinerarioDestinoData['destino_turistico_id'] = $destinoTuristicoId;
                
                $itinerarioDestinoId = ItinerarioDestino::create($itinerarioDestinoData);

                // $itinerarioDestinoResponse = $this->itinerario_destino->store($itinerarioDestinoData);

                // if ($itinerarioDestinoResponse->getStatusCode() !== 200) {
                //     throw new \Exception('Error al insertar itinerario Destino');
                // }

                // SECCION ITINERARIO SERVICIO
                $itinerarioId = $itinerarioDestinoId->id;
                $destino_turistico_detalle_servicio = $itinerarioDestinoData['destino_turistico_detalle_servicio'] ?? [];

                foreach ($destino_turistico_detalle_servicio as $itinerarioServicioData) {
                    $itinerarioServicioData['itinerario_destino_id'] = $itinerarioId;
                    $itinerarioServicioId = ItinerarioServicio::create($itinerarioServicioData);
                    // $itinerarioServicioResponse = $this->itinerario_servicio->store($itinerarioServicioData);

                    // if ($itinerarioServicioResponse->getStatusCode() !== 200) {
                    //     throw new \Exception('Error al insertar itinerario servicio');
                    // }
                }
            }
            return [                
                'destinoTuristico' => $destinoTuristicoId,           
                'itinerarioDestino' => $itinerarioDestinoId,
                'itinerarioServicio' => $itinerarioServicioId,
                'message' => 'Destino turistico y Destino servicios creados correctamente',
            ];
        });


        // try {
        //     // Extraer datos del modelo principal
        //     $destinoTuristico = $request->except(['destino_turistico_detalle', 'destino_turistico_detalle_servicio']);
        
        //     // Crear el registro principal
        //     $destinoTuriaticoResponse = DestinoTuristico::create($destinoTuristico);
        
        //     // Aquí puedes acceder al ID del registro creado, por ejemplo:
        //     $id = $destinoTuriaticoResponse->id;
        
        //     // Retornar una respuesta exitosa
        //     return response()->json([
        //         'message' => 'Destino Turístico creado con éxito id: ' . $id,
        //         'data' => $destinoTuriaticoResponse,
        //     ], 201);
        
        // } catch (\Exception $e) {
        //     // Manejar cualquier error
        //     return response()->json([
        //         'message' => 'Error al insertar destino turístico',
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }

    public function DestinoCategories(Request $request)
    {
        $data = $request->all();
        $servicioDetalle = ServicioDetalle::getFormattedForDropdown($data['proveedor_categoria_id']);
        return response()->json($servicioDetalle);
    }

    /**
     * Display the specified resource.
     */
    public function show(DestinoTuristico $destinoTuristico)
    {
        // return Inertia::render('DestinoTuristico/Show', compact('destinoTuristico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinoTuristico $destinoTuristico)
    {        
        $destinoTuristico = DestinoTuristico::with('itinerarios.servicios')->find($destinoTuristico->id);
        dd($destinoTuristico->toArray());
        
        if (!$destinoTuristico) {
            return response()->json(['message' => 'Destino turístico no encontrado'], 404);
        }

        $response = [
            'nombre' => $destinoTuristico->nombre,
            'descripcion' => $destinoTuristico->descripcion,
            'destino_turistico_detalle' => []
        ];

        foreach ($destinoTuristico->itinerariosDestino as $itinerarioDestino) {
            $itinerario = $itinerarioDestino->itinerario;

            $detalle = [
                'nro_dia' => $itinerarioDestino->nro_dia,
                'itinerario_id' => $itinerario->id,
                'nombre' => $itinerario->nombre,
                'destino_turistico_detalle_servicio' => []
            ];

            foreach ($itinerario->servicios as $servicio) {
                $detalle['destino_turistico_detalle_servicio'][] = [
                    'nro_orden' => $servicio->nro_orden,
                    'servicio_id' => $servicio->servicio_id,
                    'observacion' => $servicio->observacion,
                    'costo' => $servicio->costo
                ];
            }

            $response['destino_turistico_detalle'][] = $detalle;
        }

        return response()->json($response);

        
        dd($destinoTuristico);

        $destinoTuristicoDetalle = ItinerarioDestino::where('destino_turistico_id', $destinoTuristico->id)->get();
        $destinoTuristicoDetalleServicio = ItinerarioServicio::where('destino_turistico_id', $destinoTuristico->id)->get();
        $formattedPaises = Pais::getFormattedForDropdown();
        $formattedItinerarios = Itinerario::getFormattedForDropdown();
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedProveedores = proveedor::getFormattedForDropdown();
        // $formattedCostos = Costo::getFormattedForDropdown();
        // $formattedDestinos = Destino::getFormattedForDropdown();
        // $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        $formattedServicio = Servicio::getFormattedForDropdown();
        $formattedServicioClase = ServicioClase::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('DestinoTuristico/EditDestinoTuristico', 
        [
            'ListaPaises' => $formattedPaises,
            'ListaItinerarios' => $formattedItinerarios,
            'ListaProveedorCategorias' => $formattedCategorias,
            'ListaProveedor' =>  $formattedProveedores,
            // 'categoriaDestinos' => $formattedDestinos,
            // 'categoriaDistribuciones' => $formattedDistribuciones,
            'ListaServicio' => $formattedServicio,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestinoTuristico $destinoTuristico)
    {
        $data = $request->all();
        $destinoTuristico->update($data);
        return Inertia::render('DestinoTuristico/Edit', compact('destinoTuristico'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinoTuristico $destinoTuristico)
    {
        $destinoTuristico->delete();
        return to_route('destino_turistico');
    }
}
