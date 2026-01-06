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
        ->paginate(10); //->get(); // Ordenar por ID descendente
        //dd($destinoturisticos);
        return Inertia::render('DestinoTuristico/Index', ['destinoturisticos' => $destinoturisticos]); // compact('destinoturisticos'));
        //return response()->json( ['destinoturistico' => $destinoturistico]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return Inertia::render('DestinoTuristico/Create');        
        $formattedItinerarios = Itinerario::getFormattedForDropdown();
        $formattedProveedores = proveedor::getFormattedForDropdown();
        $formattedServicio = Servicio::getFormattedForDropdown();
        return Inertia::render('DestinoTuristico/CreateDestinoTuristico', 
        [
            'Accion' => 'create',
            'ListaProveedor' =>  $formattedProveedores,
            'ListaItinerarios' => $formattedItinerarios,
            'ListaServicio' => $formattedServicio,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinoTuristicoRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // SECCION DESTINO TURISTICO
            $destinoTuristico = $request->except(['itinerario_destinos', 'itinerario_servicios']);

            if (array_key_exists('id', $destinoTuristico)) {
                //dd("entro", $destinoTuristico['id']);
                DestinoTuristico::where('id', $destinoTuristico['id'])->update(['estado_activo' => 0]);
            }

            $destinoTuriaticoResponse = DestinoTuristico::create($destinoTuristico);
            //$destinoTuriaticoResponse = $this->itinerario_destino->store($destinoTuristico);

            // if ($destinoTuriaticoResponse->getStatusCode() !== 200) {
            //     throw new \Exception('Error al insertar destinoTuristico' . json_decode($destinoTuriaticoResponse->getContent())->id);
            // } 

            // $destinoTuristicoId = json_decode($destinoTuriaticoResponse->getContent())->id;
            $destinoTuristicoId = $destinoTuriaticoResponse->id;

            // SECCION ITINERARIO DESTINO
            $itinerario_destinos = $request->get('itinerario_destinos', []);

            foreach ($itinerario_destinos as $itinerarioDestinoData) {
                // Añadir `destino_turistico_id` al itinerarioDestino
                $itinerarioDestinoData['destino_turistico_id'] = $destinoTuristicoId;
                
                $itinerarioDestinoId = ItinerarioDestino::create($itinerarioDestinoData);

                // $itinerarioDestinoResponse = $this->itinerario_destino->store($itinerarioDestinoData);

                // if ($itinerarioDestinoResponse->getStatusCode() !== 200) {
                //     throw new \Exception('Error al insertar itinerario Destino');
                // }

                // SECCION ITINERARIO SERVICIO
                $itinerarioId = $itinerarioDestinoId->id;
                $itinerario_servicios = $itinerarioDestinoData['itinerario_servicios'] ?? [];

                foreach ($itinerario_servicios as $itinerarioServicioData) {
                    $itinerarioServicioData['itinerario_destino_id'] = $itinerarioId;
                    $itinerarioServicioData['nro_dia'] = $itinerarioDestinoData['nro_dia'];
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
    }

    public function DestinoCategories(Request $request)
    {
        $data = $request->all();
        $servicioDetalle = ServicioDetalle::getFormattedForDropdown($data['proveedor_categoria_id']);
        return response()->json($servicioDetalle);
    }

    public function destinoServicios(Request $request)
    {
        $data = $request->all();
        $destinoId = $data["destino_turistico_id"];
        $destinoServicios = DestinoTuristico::with([
            'itinerarioDestinos' => function($query) {
                $query->with([
                    'itinerario',
                    'itinerarioServicios' => function($query) {
                        $query->with([
                            'servicio' => function($query) {
                                $query->with([
                                    'precios',
                                    'servicioDetalles' => function($query) {
                                        $query->select('id', 'descripcion', 'proveedor_categoria_id') // Incluye la clave foránea
                                            ->with([
                                                'proveedor_categoria' => function($query) {
                                                    $query->select('id', 'nombre'); // Solo los campos necesarios
                                                }
                                            ]);
                                    },
                                    'proveedor' => function($query) {
                                        $query->select('id', 'ruc', 'razon_social');
                                    }
                                ]);
                            },
                            //'pasajeroServicios.pasajero' // Nueva relación añadida
                        ]);
                    }
                ]);
            }
        ])->find($destinoId);
        // dd($destinoServicios->toJson());
        return response()->json($destinoServicios);
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
        //$destinoTuristico = DestinoTuristico::with('destino_turistico_detalle.destino_turistico_detalle_servicio')->find($destinoTuristico->id);
        $destinoTuristico = DestinoTuristico::with('itinerarioDestinos.itinerarioServicios')->find($destinoTuristico->id);
        //dd(json_encode($destinoTuristico, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $formattedItinerarios = Itinerario::getFormattedForDropdown();
        $formattedProveedores = proveedor::getFormattedForDropdown();
        $formattedServicio = Servicio::getFormattedForDropdown();
        return Inertia::render('DestinoTuristico/CreateDestinoTuristico', 
        [
            'Accion' => 'edit',
            'ListaProveedor' =>  $formattedProveedores,
            'ListaItinerarios' => $formattedItinerarios,
            'ListaServicio' => $formattedServicio,
            'DestinoTuristico' => $destinoTuristico
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
