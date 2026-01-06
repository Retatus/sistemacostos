<?php

namespace App\Http\Controllers;
use App\Http\Requests\proveedor\StoreRequest;
use App\Http\Requests\proveedor\UpdateRequest;
use App\Models\Costo;
use App\Models\Destino;
use App\Models\DistribucionVenta;
use App\Models\ProveedorCategoria;
use App\Models\proveedor;
use App\Models\Servicio;
use App\Models\ServicioDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener las categorías formateadas
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();

        // Parámetros de búsqueda
        $category = $request->input('proveedor_categoria') ?? ''; 
        $ruc_name = $request->input('ruc_razonsocial') ?? ''; 
        $esCliente = $category == 0 ? 1 : 0; 
        // Consulta principal
        $proveedors = Proveedor::with('categoria:id,nombre')
            ->where('estado_activo', 1)
            ->where('escliente', $esCliente)
            ->when($category, function ($query, $category) {
                return $query->where('proveedor_categoria_id', $category);
            })
            ->when($ruc_name, function ($query, $ruc_name) {
                $query->where(function ($q) use ($ruc_name) {
                    $q->where('ruc', 'LIKE', "%{$ruc_name}%")
                    ->orWhere('razon_social', 'LIKE', "%{$ruc_name}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Verificar si es una solicitud AJAX o normal
        if ($request->wantsJson()) {
            // Respuesta para solicitudes AJAX (búsquedas)
            return response()->json(['proveedors' => $proveedors, 'proveedorcategorias' => $formattedCategorias, ]);
        }

        // Respuesta para cargar la vista inicial
        return Inertia::render('proveedor/Index', ['proveedors' => $proveedors, 'proveedorcategorias' => $formattedCategorias, ]);
    }


    public function indexProveedor(Request $request)
    {
        //dd($request);
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();

        $category = $request->input('tipo_comprobante') ?? ''; 
        $ruc_name = $request->input('ruc_razonsocial'); 
        //dd($ruc_name);

        $proveedors = Proveedor::with('categoria:id,nombre')
        ->where('estado_activo', 1) // Filtra solo proveedores activos
        ->when($category, function ($query, $category) {
            // Filtrar por categoría si se proporciona
            return $query->where('proveedor_categoria_id', $category);
        })
        ->when($ruc_name, function ($query, $ruc_name) {
            // Filtrar por RUC o Razón Social si se proporciona
            $query->where(function ($q) use ($ruc_name) {
                $q->where('ruc', 'LIKE', "%{$ruc_name}%")
                ->orWhere('razon_social', 'LIKE', "%{$ruc_name}%");
            });
        })
        ->orderBy('id', 'desc') // Ordenar por ID descendente
        ->paginate(10); // Paginación con 10 elementos por página
        //$proveedors = Proveedor::with('categoria:id,nombre')->where('estado_activo', 1)->orderBy('id', 'desc')->paginate(10);

        //dd($proveedors);
        //return Inertia::render('proveedor/Index', ['proveedors' => $proveedors, 'proveedorcategorias' => $formattedCategorias]);
        return response()->json( ['proveedors' => $proveedors, 'proveedorcategorias' => $formattedCategorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {       
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        
        return Inertia::render('proveedor/CreateProveedor', 
        [
            'Accion' => 'create',
            'ListaServicioDetalle' => $formattedServicioDetalle
        ]); //compact('proveedorcategorias'));
    }

    public function createProveedor()
    {
        $proveedorCategoria = ProveedorCategoria::getFormattedForDropdown();
        return Inertia::render('proveedor/Create', ['proveedorcategorias' => $proveedorCategoria]); //compact('proveedorcategorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        //dd($request);
        $data = $request->all();
        $proveedor = proveedor::create($data);
        //return to_route('proveedor');
        if ($proveedor) {
            return response()->json([
                'message' => 'Proveedor creado exitosamente',
                'data' => $proveedor
            ], 201); // 201 Created
        } else {
            return response()->json([
                'message' => 'Error al crear el proveedor'
            ], 500); // 500 Internal Server Error
        }
    }

    public function proveedorList(Request $request)
    {
        $data = $request->all();
        $proveedorList = Proveedor::getFormattedForDropdown($data['proveedor_categoria_id']);
        return response()->json($proveedorList);
    }

    public function find(Request $request)
    {
        $tipoDoc = $request->input('tipo_documento_id'); 
        $ruc = $request->input('ruc') ?? ''; 
        $proveedorList = Proveedor::findProveedor($tipoDoc, $ruc);
        return response()->json($proveedorList);
    }

    public function proveedorAlojamiento(Request $request)
    {
        $pasajeros = $request->pasajeros;
        $categoria   = $request->categoria;

        $result = Proveedor::whereHas('servicios', function ($q) use ($categoria) {
            $q->where('estado_activo', 1)
            ->whereHas('proveedor', function ($c) use ($categoria) {
                $c->where('proveedor_categoria_id', $categoria);
            });
        })
        ->withCount([
            'servicios as capacidad_total' => function ($q) {
                $q->join('precios', 'servicios.id', '=', 'precios.servicio_id')
                  ->select(DB::raw('SUM(precios.capacidad_pax)'));
            }
        ])
        ->having('capacidad_total', '>=', $pasajeros)
        ->get(
            [
                'id',
                'ruc',
                'razon_social',
                'nombre',
                'estrellas',
                'ciudad'
            ]
        );

        return response()->json($result);
    }

    public function proveedorHabitacion($proveedorId)
    {
        return Servicio::where('proveedor_id', $proveedorId)
            ->with([
                'servicioDetalles:id,descripcion',
                'precios' => fn ($p) => $p->where('estado_activo', 1)
            ])
            ->get()
            ->map(function ($servicio) {
                return [
                    'id'                => $servicio->id,
                    'servicioDetalles'  => $servicio->servicioDetalles->descripcion,
                    'tipo_costo'        => $servicio->precios->first()->tipo_costo,
                    'tipo'   => $servicio->precios->first()->tipo_habitacion,
                    'capacidad' => $servicio->precios->first()->capacidad_pax,
                    'precio'    => (float) $servicio->precios->first()->monto,
                    'moneda'    => $servicio->precios->first()->moneda
                ];
            });
    }

    /**
     * Display the specified resource.
     */
    public function show(proveedor $proveedor)
    {
        // return Inertia::render('proveedor/Show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(proveedor $proveedor)
    {
      //$servicio = Servicio::where('proveedor_id', $proveedor->id)->get();
        $proveedor = proveedor::with('servicios.precios')->find($proveedor->id);
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown($parametro = null);
        return Inertia::render('proveedor/CreateProveedor',
        [
            'Accion' => 'edit',
            'Proveedor' => $proveedor,
            'ListaServicioDetalle' => $formattedServicioDetalle
        ]); //compact('proveedorcategorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, proveedor $proveedor)
    {
        $data = $request->all();
        $proveedor->update($data);
        return Inertia::render('proveedor/Edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEstado($id)
    {
        try {
            // Encuentra el proveedor por su ID
            $proveedor = Proveedor::findOrFail($id);
    
            // Llama al método desactivar
            $proveedor->desactivar();
    
            return response()->json(['message' => 'Proveedor desactivado con éxito.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al desactivar el proveedor: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(proveedor $proveedor)
    {
        $proveedor->delete();
        return to_route('proveedor');
    }
}
