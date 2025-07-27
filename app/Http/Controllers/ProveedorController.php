<?php

namespace App\Http\Controllers;
use App\Http\Requests\proveedor\StoreRequest;
use App\Http\Requests\proveedor\UpdateRequest;
use App\Models\Costo;
use App\Models\Destino;
use App\Models\DistribucionVenta;
use App\Models\ProveedorCategoria;
use App\Models\proveedor;
use App\Models\ServicioDetalle;
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
        // Consulta principal
        $proveedors = Proveedor::with('categoria:id,nombre')
            ->where('estado_activo', 1)
            ->where('escliente', 0)
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
        return Inertia::render('proveedor/EditProveedor',
        [
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
