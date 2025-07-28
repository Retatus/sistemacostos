<?php

namespace App\Http\Controllers;
use App\Services\CotizacionService;
use App\Http\Requests\Cotizacion\StoreRequest;
use App\Http\Requests\Cotizacion\UpdateRequest;
use App\Http\Requests\Cotizacion\CotizacionRequest;
use App\Models\Cotizacion;
use App\Models\Destino;
use App\Models\DestinoTuristico;
use App\Models\Pais;
use App\Models\Pasajero;
use App\Models\PasajeroServicio;
use App\Models\proveedor;
use App\Models\ProveedorCategoria;
use App\Models\ServicioClase;
use App\Models\TipoComprobante;
use App\Models\TipoDocumento;
use App\Models\TipoPasajero;
use App\Models\TipoSunat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use App\DTO\CotizacionDTO;
use Illuminate\Support\Facades\Log;
class CotizacionController extends Controller
{

    protected $cotizacionService;

    // Inyección de dependencias
    public function __construct(CotizacionService $cotizacionService)
    {
        $this->cotizacionService = $cotizacionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cotizacion = Cotizacion::all();
        //$cotizacions = Cotizacion::orderBy('id', 'desc')->get();
        $cotizacions = Cotizacion::with([
            'tipo_comprobante:id,nombre',
            'pais:id,nombre',
            'idioma:id,nombre',
            'mercado:id,nombre',
            'destino:id,nombre',
        ])
        ->where('estado_activo', 1)
        ->orderBy('id', 'desc')
        ->paginate(10);

        return Inertia::render('Cotizacion/Index', ['cotizacions' => $cotizacions]);
        //return response()->json( ['cotizacion' => $cotizacion]);
    }

    public function opindex(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio') ?? ''; 
        $fecha_fin = $request->input('fecha_fin') ?? ''; 
        $file_pax = $request->input('nombre_nro_pax') ?? ''; 

        $cotizacions = Cotizacion::with([
            'tipo_comprobante:id,nombre',
            'pais:id,nombre',
            'idioma:id,nombre',
            'mercado:id,nombre',
            'destino:id,nombre',
        ])
        ->where('estado_activo', 1)
        ->where('estado_cotizacion', 1)
        // ->when(function($query) use ($fecha_inicio, $fecha_fin) {
        //     if ($fecha_inicio && $fecha_fin) {
        //         return$query->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        //     }
        // }) // MEJORAR ESTA PARTE, POSTERIORMENTE      
        ->when($file_pax, function ($query, $file_pax) {
            $query->where(function ($q) use ($file_pax) {
                $q->where('file_nro', 'LIKE', "%{$file_pax}%")
                ->orWhere('file_nombre', 'LIKE', "%{$file_pax}%");
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        if ($request->wantsJson()) {
            // Respuesta para solicitudes AJAX (búsquedas)
            return response()->json(['cotizacions' => $cotizacions]);
        }

        return Inertia::render('Cotizacion/OpIndex', ['cotizacions' => $cotizacions]);
        //return response()->json( ['cotizacion' => $cotizacion]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cotizacion = CotizacionDTO::createEmpty([]);
        $correlatico = Cotizacion::generarCorrelativo();
        $formattedDestinosTuristicos = DestinoTuristico::getFormattedForDropdown();
        return Inertia::render('Cotizacion/CreateCotizacion', 
        [
            'Correlativo' => $correlatico,
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = DB::transaction(function () use ($request) {
            $data = $request->all();
            //dd(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $dataCotizacion = $request->except(['Pasajeros']);
            $dataCotizacion['file_nro'] = Cotizacion::generarCorrelativo();
            $dataCotizacion['fecha'] = Carbon::parse($dataCotizacion['fecha'])->format('Y-m-d');
            $dataCotizacion['fecha_inicio'] = Carbon::parse($dataCotizacion['fecha_inicio'])->format('Y-m-d');
            $dataCotizacion['fecha_fin'] = Carbon::parse($dataCotizacion['fecha_fin'])->format('Y-m-d');
            //Log::info('🟢 Iniciando inserción de cotización');
            //Log::debug('📥 Datos del request:', $data);
            // 1. Insertar cotización principal
            $cotizacionResponse = Cotizacion::create($dataCotizacion);

            // 2. Mapeo de IDs temporales a reales para pasajeros
            $pasajeros = $data['Pasajeros'] ?? [];
            $pasajerosMap = [];

            foreach ($pasajeros as $index => $pasajeroData) {
                // Verificar si existe un archivo 'documento_file' en el array $pasajero
                if (isset($pasajeroData['documento_file']) && $pasajeroData['documento_file'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $pasajeroData['documento_file'];
                    $rutename = $file->store('documento_pasajero', ['disk' => 'public']);
                    $pasajeroData['documento_file'] = $rutename; // Guardar la ruta del archivo en el array
                }

                // Verificar si el pasajero ya existe en la base de datos
                $pasajero = Pasajero::create([
                    ...$pasajeroData,
                    'cotizacion_id' => $cotizacionResponse->id
                ]);

                $pasajerosMap[$pasajeroData['id']] = [
                    'id' => $pasajero->id,
                    'temp_id' => $pasajeroData['temp_id'],
                    'nombre' => $pasajero->nombre,
                ];

                // ✅ Actualizar el array original
                $pasajeros[$index]['id'] = $pasajero->id;
            }
            
            // 3. Procesar días y servicios anidados
            $pasajero_servicios = $data['destino_turistico_detalle'] ?? [];
            foreach ($pasajero_servicios as $pasajero_servicio) {                   // destino_turistico_detalle

                $servicio_detalle = $pasajero_servicio['itinerario_servicios'] ?? [];
                foreach ($servicio_detalle as $servicio) {  

                    $pasajero_servicio = $servicio['pasajerosAsignados'] ?? [];
                    foreach ($pasajero_servicio as $pasajero_servicio) {
                            $pasajero_servicio_response = PasajeroServicio::create([
                                'pasajero_id' => collect($pasajerosMap)->firstWhere('temp_id', $pasajero_servicio['temp_id'])['id'],
                                'itinerario_servicio_id' => $servicio['id'] ?? [],
                                'hora' => $servicio['hora'] ?? '',
                                'observacion' => $servicio['observacion'] ?? '',
                                'moneda' => $servicio['moneda'] ?? '',
                                'monto' => $servicio['monto'] ?? 0,
                                'estatus' => $servicio['status'] ?? '0', // PENDIENTE
                                'estado_activo' => 1
                        ]);
                    }
                }
            }
            return [
                'cotizacion_id' => $cotizacionResponse->id,
                'pasajeros_map' => $pasajerosMap // Opcional: útil para debugging
            ];
        });

        // return response()->json([
        //     'success' => true,
        //     'cotizacion_id' => $response['cotizacion_id']
        // ], 201);
        return to_route('cotizacion');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cotizacion $cotizacion)
    {
        // return Inertia::render('Cotizacion/Show', compact('cotizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotizacion $cotizacion)
    {
        $cotizacion = Cotizacion::with([
            'destinosTuristicos.itinerarioDestinos' => function($query) {
                $query->with([
                    'itinerario',
                    'itinerarioServicios' => function($query) {
                        $query->with([
                            'servicio' => function($query) {
                                $query->with([
                                    'precios',
                                    'servicioDetalles'
                                ]);
                            },
                            'pasajeroServicios.pasajero' // Nueva relación añadida
                        ]);
                    }
                ]);
            }
        ])->find($cotizacion->id);

        // $cotizacion = Cotizacion::with([
        //     'destinosTuristicos.itinerarioDestinos' => function($query) {
        //         $query->with([
        //             'itinerario',
        //             'itinerarioServicios.servicio' => function($query) {
        //                 $query->with([
        //                     'precios',
        //                     'servicioDetalles'
        //                 ]);
        //             }
        //         ]);
        //     }
        // ])->find($cotizacion->id);

        // $cotizacion = Cotizacion::with([
        //     // 'destino.destino_turistico_detalle.destino_turistico_detalle_servicio.itinerario',
        //     // 'destino.destino_turistico_detalle.destino_turistico_detalle_servicio.servicio.precios',
        //     // 'destino.destino_turistico_detalle.destino_turistico_detalle_servicio.servicio.servicioDetalles' // plural
        //     'destino.destino_turistico_detalle.destino_turistico_detalle_servicio.itinerario',
        //     'destino.destino_turistico_detalle.destino_turistico_detalle_servicio.servicio.precios',
        //     'destino.destino_turistico_detalle.destino_turistico_detalle_servicio.servicio.servicioDetalles' // plural
        // ])->find($cotizacion->id);

        dd($cotizacion->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);



        $formattedDestinosTuristicos = DestinoTuristico::getFormattedForDropdown();
        $pasajero = Pasajero::where('cotizacion_id', $cotizacion->id)->get();
        $detalle = $this->cotizacionService->getCotizacionWithItinerary($cotizacion->id);
        $proveedor = proveedor::where('id', $cotizacion->proveedor_id)->get();
        $cotizacion['cliente_nro_doc'] = $proveedor[0]['ruc'] ?? '';
        $cotizacion['proveedor_razon_social'] = $proveedor[0]['razon_social'] ?? '';
        
        return Inertia::render('Cotizacion/EditCotizacion', 
        [
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos,
            'Correlativo' => $cotizacion->file_nro,
            'Cotizacion' => $cotizacion,
            'Pasajeros' => $pasajero,
            'Detalle' => $detalle,
        ]); //compact('cotizacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        $data = $request->all();
        $cotizacion->update($data);
        return Inertia::render('Cotizacion/Edit', compact('cotizacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return to_route('cotizacion');
    }
}
