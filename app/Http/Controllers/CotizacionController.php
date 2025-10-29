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
use App\Models\Servicio;
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
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos,
            'ListaServicios' => Servicio::getFormattedForDropdown(),
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
                $nro_dia = $pasajero_servicio['nro_dia'] ?? 1;
                foreach ($itinerario_servicios as $index => $servicio) {  
                    $pasajero_servicio = $servicio['pasajero_servicios'] ?? [];
                    // Verificar si hay pasajeros asignados
                    $pasajero_asignados = $pasajero_servicio['pasajerosAsignados'] ?? [];
                    if (!empty($pasajero_asignados)) {
                        foreach ($pasajero_asignados as $pasajero_asignado) {
                            //Log::info('🟢 Iniciando inserción de pasajero_servicio. PasajerosMap: ' . json_encode($pasajerosMap) . ' | Pasajero temp_id: ' . $pasajero_asignado['temp_id']. ' moneda '. $pasajero_servicio['moneda']);
                            $pasajero_servicio_response = PasajeroServicio::create([
                                'nro_dia' => $nro_dia,
                                'nro_orden' => $index + 1, // Asignar el número de orden basado en el índice del servicio
                                'cotizacion_id' => $cotizacionResponse->id,
                                'pasajero_id' => collect($pasajerosMap)->firstWhere('temp_id', $pasajero_asignado['temp_id'])['id'] ?? null,
                                'itinerario_servicio_id' => $pasajero_servicio['itinerario_servicio_id'] ?? null,
                                'servicio_id' => $pasajero_servicio['servicio_id'] ?? null,
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
                            'nro_dia' => $nro_dia,
                            'nro_orden' => $index + 1, // Asignar el número de orden basado en el índice del servicio
                            'cotizacion_id' => $cotizacionResponse->id,
                            'pasajero_id' => null, // No hay pasajero asignado
                            'itinerario_servicio_id' => $servicio['itinerario_servicio_id'] ?? null,
                            'servicio_id' => $servicio['servicio_id'] ?? null,
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
                    //'itinerario',
                    'itinerarioServicios' => function($query) use ($cotizacion) {
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
                                ]);
                            },
                            'pasajeroServicios' => function($query) use ($cotizacion) {
                                $query->select('id','nro_dia','nro_orden','hora','pasajero_id','itinerario_servicio_id','servicio_id','cotizacion_id','observacion','moneda','monto','estatus','estado_activo')->where('cotizacion_id', $cotizacion->id);
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
                'servicio_id' => $pasajero_servicio['servicio_id'] ?? '0',
                'itinerario_destino_id' => null,
                'proveedor_categoria_id' => '0',
                'proveedor_id' => null,
                'observacion' => $pasajero_servicio['observacion'] ?? '',
                'monto' => $pasajero_servicio['monto'] ?? 0,
                'estado_activo' => 1,
                'pasajeroServicios' => [
                    $pasajero_servicio
                ]
            ];
        });

        // Generar un UUID para cada pasajero (solo en la respuesta)
        if ($cotizacion && $cotizacion->pasajeros) {
            $cotizacion->pasajeros->transform(function($pasajero) {
                $pasajero->temp_id = (string) Str::uuid();
                return $pasajero;
            });
        }

        //dd(json_encode($mapServiciosNoRelacionados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $printJson = $this->addingJson($cotizacion->destinosTuristicos->itinerarioDestinos->toArray(), $mapServiciosNoRelacionados->toArray());

        //dd(json_encode($printJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $resultadoAgrupado =  $this->agruparPasajerosPorOrden($printJson, $cotizacion->pasajeros->toArray(), $cotizacion->id);

        //dd(json_encode($resultadoAgrupado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));


        


        $mergeTemporal = $this->mergeServicios($cotizacion->destinosTuristicos->itinerarioDestinos, $mapServiciosNoRelacionados); 

        //dd(json_encode($mergeTemporal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $cotizacion->destinosTuristicos->itinerarioDestinos = $mergeTemporal;
        
        

        $servicios = collect($cotizacion->pasajerosServicios);
        //dd($servicios->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //dd(json_encode($servicios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        //dd(json_encode($cotizacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        
        $agrupado = $servicios->groupBy('nro_dia')->values()->map(function ($itemsPorDia, $indexDay) use ($cotizacion) {
            
                return [
                    'id' => $cotizacion->destinosTuristicos->itinerarioDestinos[$indexDay]->id ?? 0,
                    'nro_dia' => $itemsPorDia->first()->nro_dia ?? 0,
                    'nro_orden' => $itemsPorDia->first()->nro_orden ?? 1,
                    
                    'nombre' => $cotizacion->destinosTuristicos->itinerarioDestinos[$indexDay]->nombre ?? '',
                    'descripcion' => $cotizacion->destinosTuristicos->itinerarioDestinos[$indexDay]->descripcion ?? '',
                    'observacion' => $cotizacion->destinosTuristicos->itinerarioDestinos[$indexDay]->observacion ?? '',

                    'itinerario_servicios' => $itemsPorDia->groupBy('itinerario_servicio_id')->values()->map(function ($ps, $indexItinerarioServicio) use ($cotizacion, $indexDay) {
                        // Factor común de los campos (tomando el primero)
                        Log::warning(' 🔴  Agrupando indices ' . $indexDay++ . '.' . $indexItinerarioServicio++ . ' y servicio ID ');
                        Log::debug('🟢 Agrupando servicios para el día ' . ($ps ?? 'N/A') . ' y servicio ID ' . ($ps ?? 'N/A') . ' | Índice: ' . $indexItinerarioServicio);
                        $base = [
                            "cotizacion_id" => $ps[0]->cotizacion_id ?? null,
                            "id" => $ps[0]->itinerario_servicio_id ?? 0,
                            "nro_orden" => $ps[0]->nro_orden,
                            "hora" => $ps[0]->hora,
                            "servicio_id" => $ps[0]->servicio_id ?? 0,
                            "itinerario_destino_id" => $ps[0]->itinerario_destino_id,
                            "observacion" => $ps[0]->observacion,
                            "monto" => (string) collect($ps)->sum('monto'),
                            "estatus" => (string) $ps[0]->estatus,
                            "estado_activo" => $ps[0]->estado_activo,
                            "servicio" => [
                                    "id" => $ps[0]->servicio_id,
                                    "proveedor_id" => ($ps[0]->servicio->proveedor_id ?? 0),
                                    "precios" => [
                                        "id" =>  ($ps[0]->servicio->precios->first()->id ?? 0),
                                        "anio" => (string) ($ps[0]->servicio->precios->first()->anio ?? ''),
                                        "moneda" => (string) ($ps[0]->servicio->precios->first()->moneda ?? ''),
                                        "monto" => (string) ($ps[0]->servicio->precios->first()->monto ?? '0'),
                                        "tipo_pasajero_id" => ($ps[0]->servicio->precios->first()->tipo_pasajero_id ?? 3),
                                        "servicio_id" => ($ps[0]->servicio->precios->first()->servicio_id ?? 0),
                                        "servicio_clase_id" => ($ps[0]->servicio->precios->first()->servicio_clase_id ?? 0),
                                        "estado_activo" => ($ps[0]->servicio->precios->first()->estado_activo ?? 1)
                                    ],
                                    "servicio_detalles" => null
                                ],
                            "pasajero_servicios" => [
                                "cotizacion_id" => $ps[0]->cotizacion_id ?? null,
                                "itinerario_servicio_id" => $ps[0]->itinerario_servicio_id,
                                "itinerario_destino_id" => $ps[0]->itinerario_destino_id,
                                "hora" => $ps[0]->hora,
                                "observacion" => $ps[0]->observacion,
                                "moneda" => $ps[0]->moneda,
                                "monto" => collect($ps)->sum('monto'),
                                "cantidad_pasajeros" => collect($ps)->count(),
                                "subtotal" => collect($ps)->sum('monto'),
                                "estatus" => $ps[0]->estatus,
                                "estado_activo" => $ps[0]->estado_activo,
                               
                                "pasajerosAsignados" => 
                                    collect($ps)->map(function ($item) use ($cotizacion) {
                                        $pasajero = $cotizacion->pasajeros->firstWhere('id', $item->pasajero_id);
                                        if ($pasajero) {
                                            return [
                                                "id" => $item->pasajero_id,
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

           // dd($agrupado->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        //dd($agrupado->toJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);            
        //dd(json_encode($agrupado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $cotizacion['pasajeros_servicios_agrupados'] = $agrupado;
        $cotizacion['pasajeros_servicios_agrupados1'] = $resultadoAgrupado;
        //dd(json_encode($cotizacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $formattedDestinosTuristicos = DestinoTuristico::getFormattedForDropdown();
        $formatterCategorias = ProveedorCategoria::getFormattedForDropdown();
        // $pasajero = Pasajero::where('cotizacion_id', $cotizacion->id)->get();
        // $detalle = $this->cotizacionService->getCotizacionWithItinerary($cotizacion->id);
        $proveedor = proveedor::where('id', $cotizacion->proveedor_id)->get();
        $cotizacion['cliente_nro_doc'] = $proveedor[0]['ruc'] ?? '';
        $cotizacion['proveedor_razon_social'] = $proveedor[0]['razon_social'] ?? '';
        
        return Inertia::render('Cotizacion/CreateCotizacion', 
        [
            'Accion' => 'edit',
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos,
            'ListaCategorias' => ProveedorCategoria::getFormattedForDropdown(),
            'ListaServicios' => Servicio::getFormattedForDropdown(),
            'Cotizacion' => $cotizacion,
            // 'Pasajeros' => $pasajero,
            // 'Detalle' => $detalle,
        ]); //compact('cotizacion'));
    }

    function agruparPasajerosPorOrden(array $json, array $pasajeros, int $cotizacionId): array {
        foreach ($json as &$dia) {
            $resultado = [];
            //$resultado['cotizacion_id'] = $cotizacionId;

            foreach ($dia['itinerario_servicios'] as $servicio) {
                $servicio['cotizacion_id'] = $cotizacionId;
                foreach ($servicio['pasajero_servicios'] as $pasajero) {
                    $orden = $pasajero['nro_orden'] ?? null;
                    $pasajeroAsignado = collect($pasajeros)->firstWhere('id', $pasajero['pasajero_id']);

                    if ($orden !== null) {
                        // Si no existe el grupo, inicializarlo con los datos del servicio
                        if (!isset($resultado[$orden])) {
                            $grupo = $servicio;
                            unset($grupo['pasajero_servicios']);
                            $grupo['pasajero_servicios'] = [
                                'cotizacion_id' => $cotizacionId,
                                'itinerario_servicio_id' => $grupo['id'] ?? null,
                                'itinerario_destino_id' => $grupo['itinerario_destino_id'] ?? null,
                                'hora' => $pasajero['hora'] ?? '00:00',
                                'observacion' => $pasajero['observacion'] ?? '',
                                'moneda' => $pasajero['moneda'] ?? 'USD',
                                'monto' => intval($pasajero['monto']) ?? 0,
                                'cantidad_pasajeros' => collect($pasajero['nro_orden'])->count(),
                                'subtotal' => intval($pasajero['monto']) ?? 0, //$pasajero['monto'] ?? '0',
                                'estatus' => intval($pasajero['estatus']) ?? 0, //$pasajero['estatus'] ?? '0',
                                'estado_activo' => $pasajero['estado_activo'] ?? 1,
                                'pasajerosAsignados' => []
                            ];
                            $resultado[$orden] = $grupo;
                        }

                        // Agregar pasajero al grupo
                        $resultado[$orden]['pasajero_servicios']['pasajerosAsignados'][] = $pasajeroAsignado ?
                        [
                            "id" => $pasajeroAsignado['id'] ?? '',
                            "temp_id" => $pasajeroAsignado['temp_id'] ?? '',
                            "pasajero_id" => $pasajeroAsignado['id'] ?? '',
                            "nombre" => $pasajeroAsignado['nombre'] ?? '',
                            "tipo_pasajero_id" => (string) ($pasajeroAsignado['tipo_pasajero_id'] ?? '3')
                        ] : null;

                        $resultado[$orden]['pasajero_servicios']['cantidad_pasajeros'] = collect($resultado[$orden]['pasajero_servicios']['pasajerosAsignados'])->count();

                    } else {
                        // Pasajeros sin servicio asignado
                        $grupo = [
                            'nro_orden' => null,
                            'servicio_id' => '0',
                            'itinerario_destino_id' => $pasajero['itinerario_destino_id'] ?? '0',
                            'proveedor_categoria_id' => '0',
                            'proveedor_id' => '0',
                            'servicio' => [
                                'id' => null,
                                'proveedor_id' => '0',
                                'servicio_detalle_id' => '0',
                                'ubicacion_id' => '0',
                                'estado_activo' => '1'
                            ],
                            'pasajero_servicios' => [
                                'cotizacion_id' => $cotizacionId,
                                'itinerario_servicio_id' => null,
                                'itinerario_destino_id' => $pasajero['itinerario_destino_id'] ?? '0',
                                'hora' => $pasajero['hora'] ?? '00:00',
                                'observacion' => $pasajero['observacion'] ?? 'SIN SERVICIO',
                                'moneda' => $pasajero['moneda'] ?? 'USD',
                                'monto' => $pasajero['monto'] ?? '0',
                                'cantidad_pasajeros' => collect($pasajero['nro_orden'])->count(),
                                'subtotal' => $pasajero['monto'] ?? '0',
                                'estatus' => $pasajero['estatus'] ?? '0',
                                'estado_activo' => $pasajero['estado_activo'] ?? 1,
                                'pasajerosAsignados' => $pasajeroAsignado ? [
                                    "id" => $pasajeroAsignado->id,
                                    "temp_id" => $pasajeroAsignado->temp_id ?? '',
                                    "pasajero_id" => $pasajeroAsignado->id ?? '',
                                    "nombre" => 'tatus', // $pasajeroAsignado->nombre ?? '',
                                    "tipo_pasajero_id" => (string) ($pasajeroAsignado->tipo_pasajero_id ?? '3')
                                ] : []
                            ]
                        ];
                        $resultado[] = $grupo;
                        //            $grupo['pasajero_servicios']['cantidad_pasajeros'] =             collect($grupo['pasajero_servicios']['pasajerosAsignados'])->count();
                        //$resultado[$orden]['pasajero_servicios']['cantidad_pasajeros'] = collect($resultado[$orden]['pasajero_servicios']['pasajerosAsignados'])->count();
                    }
                }
            }

            // Reemplazar 'itinerario_servicios' con la agrupación
            // $dia['cotizacion_id'] = $cotizacionId;
            $dia['itinerario_servicios'] = array_values($resultado);
        }

        return $json;
    }

    public function addingJson($primerJson, $segundoJson)
    {
        foreach ($segundoJson as $nuevoServicio) {
            $dia = $nuevoServicio['nro_dia'];
            $pasajero = $nuevoServicio['pasajeroServicios'][0];

            foreach ($primerJson as &$itinerarioDia) {
                if ($itinerarioDia['nro_dia'] === $dia) {
                    // Asegurar que itinerario_servicios sea un array
                    if (!isset($itinerarioDia['itinerario_servicios']) || !is_array($itinerarioDia['itinerario_servicios'])) {
                        $itinerarioDia['itinerario_servicios'] = [];
                    }

                    $nuevoItem = [
                        'id' => $nuevoServicio['id'],
                        'nro_orden' => $nuevoServicio['nro_orden'],
                        'hora' => $nuevoServicio['hora'],
                        'servicio_id' => $nuevoServicio['servicio_id'],
                        'itinerario_destino_id' => $nuevoServicio['itinerario_destino_id'],
                        'proveedor_categoria_id' => $nuevoServicio['proveedor_categoria_id'],
                        'proveedor_id' => $nuevoServicio['proveedor_id'],
                        'observacion' => $nuevoServicio['observacion'],
                        'monto' => $nuevoServicio['monto'],
                        'estado_activo' => $nuevoServicio['estado_activo'],
                        'pasajero_servicios' => [$pasajero]
                    ];

                    $insertado = false;
                    foreach ($itinerarioDia['itinerario_servicios'] as $index => $servicioExistente) {
                        $existente = $servicioExistente['pasajero_servicios'][0] ?? null;

                        if ($existente) {
                            if (
                                $pasajero['nro_orden'] < $existente['nro_orden'] ||
                                ($pasajero['nro_orden'] === $existente['nro_orden'] && $pasajero['id'] < $existente['id'])
                            ) {
                                array_splice($itinerarioDia['itinerario_servicios'], $index, 0, [$nuevoItem]);
                                $insertado = true;
                                break;
                            }
                        }
                    }

                    if (!$insertado) {
                        $itinerarioDia['itinerario_servicios'][] = $nuevoItem;
                    }
                }
            }
        }
        return $primerJson;
    }

     /**
     * Merges additional services into the itineraries based on matching day numbers.
     */

    public function mergeServicios($itinerarios, $serviciosAdicionales)
    {
        return $itinerarios->values()->map(function ($itinerario, $key) use ($serviciosAdicionales) {
            // Trabajar directamente con el objeto
            $itinerario_servicios = collect($itinerario->itinerario_servicios);

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

                $itinerario_servicios->push($nuevoServicio);
            }

            // Reemplazar la relación con la colección modificada
            $itinerario->itinerario_servicios = $itinerario_servicios
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
