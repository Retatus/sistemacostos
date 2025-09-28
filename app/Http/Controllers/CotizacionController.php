<?php

namespace App\Http\Controllers;
use App\Services\CotizacionService;
use App\Http\Requests\Cotizacion\StoreRequest;
use App\Http\Requests\Cotizacion\UpdateRequest;
use App\Http\Requests\Cotizacion\CotizacionRequest;
use App\Models\Cotizacion;
use App\Models\Destino;
use App\Models\DestinoTuristico;
use App\Models\ItinerarioServicio;
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
use Illuminate\Support\Str;
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
            'Accion' => 'create',
            'Cotizacion' => $cotizacion,
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
            $dataCotizacion = $request->except(['pasajeros']);
            $dataCotizacion['file_nro'] = Cotizacion::generarCorrelativo();
            $dataCotizacion['fecha'] = Carbon::parse($dataCotizacion['fecha'])->format('Y-m-d');
            $dataCotizacion['fecha_inicio'] = Carbon::parse($dataCotizacion['fecha_inicio'])->format('Y-m-d');
            $dataCotizacion['fecha_fin'] = Carbon::parse($dataCotizacion['fecha_fin'])->format('Y-m-d');
            //Log::info('🟢 Iniciando inserción de cotización');
            //Log::debug('📥 Datos del request:', $data);
            // 1. Insertar cotización principal
            $cotizacionResponse = Cotizacion::create($dataCotizacion);

            // 2. Mapeo de IDs temporales a reales para pasajeros
            $pasajeros = $data['pasajeros'] ?? [];
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
            //dd(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            // 3. Procesar días y servicios anidados
            $pasajero_servicios = $data['destino_turistico_detalle'] ?? [];
            //dd($pasajero_servicios);
            foreach ($pasajero_servicios as $pasajero_servicio) {                   // destino_turistico_detalle
                $itinerario_servicios = $pasajero_servicio['itinerario_servicios'] ?? [];
                foreach ($itinerario_servicios as $index => $servicio) {  
                    $pasajero_servicio = $servicio['pasajero_servicios'] ?? [];
                    // Verificar si hay pasajeros asignados
                    $pasajero_asignados = $pasajero_servicio['pasajerosAsignados'] ?? [];
                    if (!empty($pasajero_asignados)) {
                        foreach ($pasajero_asignados as $pasajero_asignado) {
                            //Log::info('🟢 Iniciando inserción de pasajero_servicio. PasajerosMap: ' . json_encode($pasajerosMap) . ' | Pasajero temp_id: ' . $pasajero_asignado['temp_id']. ' moneda '. $pasajero_servicio['moneda']);
                            $pasajero_servicio_response = PasajeroServicio::create([
                                'nro_orden' => $index + 1, // Asignar el número de orden basado en el índice del servicio
                                'cotizacion_id' => $cotizacionResponse->id,
                                'pasajero_id' => collect($pasajerosMap)->firstWhere('temp_id', $pasajero_asignado['temp_id'])['id'] ?? null,
                                'itinerario_servicio_id' => $pasajero_servicio['itinerario_servicio_id'] ?? null,
                                'hora' => $pasajero_servicio['hora'] ?? '',
                                'itinerario_destino_id' => $pasajero_servicio['itinerario_destino_id'] ?? 0,
                                'observacion' => $pasajero_servicio['observacion'] ?? '',
                                'moneda' => $pasajero_servicio['moneda'] ?? '',
                                'monto' => $pasajero_servicio['monto'] ?? 0,
                                'estatus' => $pasajero_servicio['estatus'] ?? '0', // PENDIENTE
                                'estado_activo' => 1
                            ]);                            
                        }
                    } else {
                        //Log::info('🟢 Iniciando inserción de pasajero_servicio sin pasajero asignado');
                        $pasajero_servicio_response = PasajeroServicio::create([
                            'nro_orden' => $index + 1, // Asignar el número de orden basado en el índice del servicio
                            'cotizacion_id' => $cotizacionResponse->id,
                            'pasajero_id' => null, // No hay pasajero asignado
                            'itinerario_servicio_id' => $servicio['itinerario_servicio_id'] ?? null,
                            'hora' => $pasajero_servicio['hora'] ?? '',
                            'itinerario_destino_id' => $pasajero_servicio['itinerario_destino_id'] ?? 0,
                            'observacion' => $pasajero_servicio['observacion'] ?? '',
                            'moneda' => $pasajero_servicio['moneda'] ?? '',
                            'monto' => $pasajero_servicio['monto'] ?? 0,
                            'estatus' => $pasajero_servicio['estatus'] ?? '0', // PENDIENTE
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
            'destinosTuristicos.itinerarioDestinos' => function($query) use ($cotizacion) {
                $query->with([
                    'itinerario',
                    'itinerarioServicios' => function($query) use ($cotizacion) {
                        $query->with([
                            'servicio' => function($query) {
                            $query->with([
                                'precios',
                                'servicioDetalles'
                            ]);
                            }
                        ]);
                    }
                ]);
            },
            'pasajeros' => function($query) use ($cotizacion) {
                $query->where('cotizacion_id', $cotizacion->id);
            },
            'pasajerosServicios' => function($query) use ($cotizacion) {
                $query->where('cotizacion_id', $cotizacion->id);
            }
        ])->find($cotizacion->id);

        $coleccionServiciosNoRelacionados = collect(PasajeroServicio::whereNull('itinerario_servicio_id')
        ->where('cotizacion_id', $cotizacion->id)
        ->get());

        // MAPEAR LOS SERVICIOS QUE NO TIENEN RELACION CON ITINERARIO_SERVICIO  
        $mapServiciosNoRelacionados = $coleccionServiciosNoRelacionados->map(function($pasajero_servicio) {
            return [
                'id' => $pasajero_servicio['itinerario_servicio_id'] ?? null,
                'nro_dia' => $pasajero_servicio['nro_dia'] ?? 0,
                'nro_orden' => $pasajero_servicio['nro_orden'] ?? 1,
                'hora' => $pasajero_servicio['hora'] ?? '',
                'servicio_id' => $pasajero_servicio['servicio_id'] ?? null,
                'itinerario_destino_id' => null,
                'proveedor_categoria_id' => null,
                'proveedor_id' => null,
                'observacion' => $pasajero_servicio['observacion'] ?? '',
                'monto' => $pasajero_servicio['monto'] ?? 0,
                'estado_activo' => 1,
                'pasajeroServicios' => [
                    $pasajero_servicio
                ]
            ];
        });

        $mergeTemporal = $this->mergeServicios($cotizacion->destinosTuristicos->itinerarioDestinos, $mapServiciosNoRelacionados); 

        $cotizacion->destinosTuristicos->itinerarioDestinos = $mergeTemporal;
        
        // Generar un UUID para cada pasajero (solo en la respuesta)
        if ($cotizacion && $cotizacion->pasajeros) {
            $cotizacion->pasajeros->transform(function($pasajero) {
                $pasajero->temp_id = (string) Str::uuid();
                return $pasajero;
            });
        }

        $servicios = collect($cotizacion->pasajerosServicios);
        //dd($servicios->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //dd(json_encode($servicios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));


        $agrupado = $servicios->groupBy('nro_dia')->map(function ($itemsPorDia) use ($cotizacion) {
                return [
                    'nro_dia' => $itemsPorDia->first()->nro_dia ?? 0,
                    'nro_orden' => $itemsPorDia->first()->nro_orden ?? 1,
                    'hora' => 'tatusssssssssssssssss',
                    'nombre' => $cotizacion->destinosTuristicos->itinerarioDestinos->where('nro_dia', $itemsPorDia->first()->nro_dia)->first()->itinerario->nombre ?? '',
                    'descripcion' => $cotizacion->destinosTuristicos->itinerarioDestinos->where('nro_dia', $itemsPorDia->first()->nro_dia)->first()->itinerario->descripcion ?? '',
                    'observacion' => $cotizacion->destinosTuristicos->itinerarioDestinos->where('nro_dia', $itemsPorDia->first()->nro_dia)->first()->itinerario->observacion ?? '',
                    'itinerario_servicios' => $itemsPorDia->groupBy('itinerario_servicio_id')->map(function ($ps) use ($cotizacion) {
                        // Factor común de los campos (tomando el primero)
                        $base = [
                            "cotizacion_id" => $ps[0]->cotizacion_id ?? null,
                            "nro_dia" => $ps[0]->nro_dia,
                            "nro_orden" => $ps[0]->nro_orden,
                            "hora" => $ps[0]->hora,
                            "itinerario_servicio_id" => $ps[0]->itinerario_servicio_id,
                            "servicio_id" => $ps[0]->servicio_id,
                            "observacion" => $ps[0]->observacion,
                            "moneda" => $ps[0]->moneda,
                            "monto" => (string) collect($ps)->sum('monto'),
                            "estatus" => (string) $ps[0]->estatus,
                            "estado_activo" => (string) $ps[0]->estado_activo,
                            "pasajero_servicios" => [
                                "cotizacion_id" => $ps[0]->cotizacion_id ?? null,
                                "itinerario_servicio_id" => $ps[0]->itinerario_servicio_id,
                                "itinerario_destino_id" => 0,
                                "hora" => $ps[0]->hora,
                                "observacion" => $ps[0]->observacion,
                                "moneda" => $ps[0]->moneda,
                                "monto" => (string) collect($ps)->sum('monto'),
                                "cantidad_pasajeros" => (string) collect($ps)->count(),
                                "subtotal" => (string) collect($ps)->sum('monto'),
                                "estatus" => (string) $ps[0]->estatus,
                                "estado_activo" => (string) $ps[0]->estado_activo,
                                "servicio" => [
                                    "id" => (string) $ps[0]->servicio_id,
                                    "proveedor_id" => (string) ($ps[0]->servicio->proveedor_id ?? ''),
                                    "precios" => [
                                        "id" => (string) ($ps[0]->servicio->precios->first()->id ?? ''),
                                        "moneda" => (string) ($ps[0]->servicio->precios->first()->moneda ?? ''),
                                        "anio" => (string) ($ps[0]->servicio->precios->first()->anio ?? ''),
                                        "monto" => (string) ($ps[0]->servicio->precios->first()->monto ?? '0'),
                                        "tipo_pasajero_id" => (string) ($ps[0]->servicio->precios->first()->tipo_pasajero_id ?? '3'),
                                        "servicio_id" => (string) ($ps[0]->servicio->precios->first()->servicio_id ?? ''),
                                        "servicio_clase_id" => (string) ($ps[0]->servicio->precios->first()->servicio_clase_id ?? ''),
                                        "estado_activo" => (string) ($ps[0]->servicio->precios->first()->estado_activo ?? '1')
                                    ],
                                    "servicio_detalles" => null
                                ],
                                "pasajerosAsignados" => 
                                    collect($ps)->map(function ($item) use ($cotizacion) {
                                        $pasajero = $cotizacion->pasajeros->firstWhere('id', $item->pasajero_id);
                                        if ($pasajero) {
                                            return [
                                                "id" => (string) $item->pasajero_id,
                                                "temp_id" => isset($pasajero->temp_id) ? $pasajero->temp_id : '',
                                                "pasajero_id" => $pasajero->id ?? '',
                                                "nombre" => $pasajero?->nombre ?? '',
                                                "tipo_pasajero_id" => (string) ($pasajero?->tipo_pasajero_id ?? '3')
                                            ];
                                        }else{
                                            return null; // O manejar de otra forma si no se encuentra el pasajero
                                        }
                                    })->toArray()                            
                            ]
                        ];
                        return $base;
                    })->values()
                ];
            })->values();

        //dd($agrupado->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);            
        //dd(json_encode($agrupado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $cotizacion['pasajeros_servicios_agrupados'] = $agrupado;
        
        //dd($cotizacion->destinosTuristicos->itinerarioDestinos->toJson());
        
        //dd($iterarioDestino->toArray());
        // dd($cotizacion0->destinosTuristicos->itinerarioDestinos->toArray());
        
        //dd($cotizacion->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //dd($cotizacion->toArray());

        $formattedDestinosTuristicos = DestinoTuristico::getFormattedForDropdown();
        // $pasajero = Pasajero::where('cotizacion_id', $cotizacion->id)->get();
        // $detalle = $this->cotizacionService->getCotizacionWithItinerary($cotizacion->id);
        $proveedor = proveedor::where('id', $cotizacion->proveedor_id)->get();
        $cotizacion['cliente_nro_doc'] = $proveedor[0]['ruc'] ?? '';
        $cotizacion['proveedor_razon_social'] = $proveedor[0]['razon_social'] ?? '';
        
        //dd($cotizacion->toArray());
        return Inertia::render('Cotizacion/CreateCotizacion', 
        [
            'Accion' => 'edit',
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos,
            'Cotizacion' => $cotizacion,
            // 'Pasajeros' => $pasajero,
            // 'Detalle' => $detalle,
        ]); //compact('cotizacion'));
    }

    public function mergeServicios($itinerarios, $serviciosAdicionales)
    {
        return $itinerarios->map(function ($itinerario) use ($serviciosAdicionales) {
            // Trabajar directamente con el objeto
            $itinerarioServicios = collect($itinerario->itinerarioServicios);

            $adicionalesDelDia = $serviciosAdicionales->filter(function ($item) use ($itinerario) {
                return isset($item['pasajeroServicios'][0]['nro_dia']) &&
                    $item['pasajeroServicios'][0]['nro_dia'] == $itinerario->nro_dia;
            });

            foreach ($adicionalesDelDia as $adicional) {
                $nuevoServicio = new ItinerarioServicio(); // Usa tu modelo real
                
                $nuevoServicio->id = null;
                $nuevoServicio->nro_orden = $adicional['nro_orden'];
                $nuevoServicio->servicio_id = null;
                $nuevoServicio->itinerario_destino_id = $itinerario->id;
                $nuevoServicio->proveedor_categoria_id = null;
                $nuevoServicio->proveedor_id = null;
                $nuevoServicio->observacion = $adicional['observacion'];
                $nuevoServicio->setRelation('pasajeroServicios', $adicional['pasajeroServicios']);

                $itinerarioServicios->push($nuevoServicio);
            }

            // Reemplazar la relación con la colección modificada
            $itinerario->itinerarioServicios = $itinerarioServicios
                ->sortBy('nro_orden')
                ->values();

            return $itinerario;
        });
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
