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
                        $pasajero_servicio_response = PasajeroServicio::create([
                            'nro_dia' => $nro_dia,
                            'nro_orden' => $index + 1, // Asignar el número de orden basado en el índice del servicio
                            'cotizacion_id' => $cotizacionResponse->id,
                            'pasajero_id' => null, // No hay pasajero asignado
                            'itinerario_servicio_id' => $pasajero_servicio['itinerario_servicio_id'] ?? null,
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
                    'itinerario',
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
                                    'proveedor' => function($query) {
                                        $query->select('id', 'ruc', 'razon_social');
                                    }
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
            // tatus
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

        $pasajeros = $cotizacion->pasajeros;

        $mapServiciosRelacionados = $cotizacion->destinosTuristicos->itinerarioDestinos;
        
        $totalServiciosConSinItinerario = $this->agregarServiciosSinItinerario($mapServiciosRelacionados, $mapServiciosNoRelacionados->toArray());        
        
        $resultadoAgrupado =  $this->agruparPasajerosPorOrden($totalServiciosConSinItinerario->toArray(), $pasajeros->toArray(), $cotizacion->id);       
        
        $cotizacion['pasajeros_servicios_agrupados'] = $resultadoAgrupado;
        //dd(json_encode($cotizacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $formattedDestinosTuristicos = DestinoTuristico::getFormattedForDropdown();
        // $formatterCategorias = ProveedorCategoria::getFormattedForDropdown();
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

    function agruparPasajerosPorOrden(array $itinerarioServicio, array $pasajeros, int $cotizacionId): array
{
    foreach ($itinerarioServicio as &$dia) {

        $resultado = [];

        foreach ($dia['itinerario_servicios'] as $servicio) {

            foreach ($servicio['pasajero_servicios'] as $pasajero) {

                $orden = $pasajero['nro_orden'] ?? null;
                $pasajeroAsignado = collect($pasajeros)->firstWhere('id', $pasajero['pasajero_id']);

                // ------------------------------
                // 1. PASAJERO CON SERVICIO
                // ------------------------------
                if ($orden !== null) {

                    // Crear grupo si no existe
                    if (!isset($resultado[$orden])) {

                        // COPIAR TODO EL SERVICIO ORIGINAL
                        $grupo = $servicio;

                        // Reemplazar pasajero_servicios por estructura base
                        $grupo['pasajero_servicios'] = [
                            'cotizacion_id' => $cotizacionId,
                            'itinerario_servicio_id' => $servicio['id'],
                            'itinerario_destino_id' => $servicio['itinerario_destino_id'],
                            'nro_orden' => $orden,
                            'hora' => $pasajero['hora'] ?? '00:00',
                            'observacion' => $pasajero['observacion'] ?? '',
                            'moneda' => $pasajero['moneda'] ?? 'USD',
                            'monto' => (float) ($pasajero['monto'] ?? 0),
                            'subtotal' => (float) ($pasajero['monto'] ?? 0),
                            'estatus' => (int) ($pasajero['estatus'] ?? 0),
                            'estado_activo' => $pasajero['estado_activo'] ?? 1,
                            'pasajerosAsignados' => []
                        ];

                        $resultado[$orden] = $grupo;
                    }

                    // Agregar pasajero
                    if ($pasajeroAsignado) {
                        $resultado[$orden]['pasajero_servicios']['pasajerosAsignados'][] = [
                            'id' => $pasajeroAsignado['id'],
                            'temp_id' => $pasajeroAsignado['temp_id'] ?? '',
                            'pasajero_id' => $pasajeroAsignado['id'],
                            'nombre' => $pasajeroAsignado['nombre'] ?? '',
                            'tipo_pasajero_id' => (string) ($pasajeroAsignado['tipo_pasajero_id'] ?? '3')
                        ];
                    }

                    // Actualizar cantidad
                    $resultado[$orden]['pasajero_servicios']['cantidad_pasajeros'] =
                        count($resultado[$orden]['pasajero_servicios']['pasajerosAsignados']);

                    continue;
                }

                // ------------------------------
                // 2. PASAJERO SIN SERVICIO
                // ------------------------------
                $resultado[] = [
                    'id' => null,
                    'nro_orden' => null,
                    'hora' => $pasajero['hora'] ?? '00:00',
                    'servicio_id' => null,
                    'itinerario_destino_id' => $pasajero['itinerario_destino_id'] ?? 0,
                    'proveedor_categoria_id' => 0,
                    'proveedor_id' => 0,
                    'observacion' => $pasajero['observacion'] ?? 'SIN SERVICIO',
                    'moneda' => $pasajero['moneda'] ?? 'USD',
                    'monto' => (float) ($pasajero['monto'] ?? 0),
                    'estado_activo' => 1,
                    'servicio' => null, // no hay servicio real
                    'pasajero_servicios' => [
                        'cotizacion_id' => $cotizacionId,
                        'itinerario_servicio_id' => null,
                        'itinerario_destino_id' => $pasajero['itinerario_destino_id'] ?? 0,
                        'nro_orden' => null,
                        'hora' => $pasajero['hora'] ?? '00:00',
                        'observacion' => $pasajero['observacion'] ?? 'SIN SERVICIO',
                        'moneda' => $pasajero['moneda'] ?? 'USD',
                        'monto' => (float) ($pasajero['monto'] ?? 0),
                        'subtotal' => (float) ($pasajero['monto'] ?? 0),
                        'estatus' => (int) ($pasajero['estatus'] ?? 0),
                        'estado_activo' => $pasajero['estado_activo'] ?? 1,
                        'cantidad_pasajeros' => $pasajeroAsignado ? 1 : 0,
                        'pasajerosAsignados' => $pasajeroAsignado ? [[
                            'id' => $pasajeroAsignado['id'],
                            'temp_id' => $pasajeroAsignado['temp_id'] ?? '',
                            'pasajero_id' => $pasajeroAsignado['id'],
                            'nombre' => $pasajeroAsignado['nombre'] ?? '',
                            'tipo_pasajero_id' => (string) ($pasajeroAsignado['tipo_pasajero_id'] ?? '3')
                        ]] : []
                    ]
                ];
            }
        }

        $dia['itinerario_servicios'] = array_values($resultado);
    }

    return $itinerarioServicio;
}

    // Metodo agregar un servicio que no esta relacionado a ningun itinerario
    public function agregarServiciosSinItinerario($serviciosRelacionados, $serviciosNoRelacionados)
    {
    foreach ($serviciosNoRelacionados as $itemNoRelacionado) {
            $dia = $itemNoRelacionado['nro_dia'];
            $pasajero = $itemNoRelacionado['pasajeroServicios'][0];

            foreach ($serviciosRelacionados as &$itinerarioDia) {
                if ($itinerarioDia['nro_dia'] === $dia) {
                    // Asegurar que itinerario_servicios sea un array
                    if (!isset($itinerarioDia['itinerario_servicios']) || !is_array($itinerarioDia['itinerario_servicios'])) {
                        $itinerarioDia['itinerario_servicios'] = [];
                    }

                    $nuevoItem = [
                        'id' => $itemNoRelacionado['id'],
                        'nro_orden' => $itemNoRelacionado['nro_orden'],
                        'hora' => $itemNoRelacionado['hora'],
                        'servicio_id' => $itemNoRelacionado['servicio_id'],
                        'itinerario_destino_id' => $itemNoRelacionado['itinerario_destino_id'],
                        'proveedor_categoria_id' => $itemNoRelacionado['proveedor_categoria_id'],
                        'proveedor_id' => $itemNoRelacionado['proveedor_id'],
                        'observacion' => $itemNoRelacionado['observacion'],
                        'monto' => $itemNoRelacionado['monto'],
                        'estado_activo' => $itemNoRelacionado['estado_activo'],
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
        return $serviciosRelacionados;
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
