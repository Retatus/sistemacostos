<?php

namespace App\Http\Controllers;
use App\Http\Requests\Servicio\StoreRequest;
use App\Models\proveedor;
use App\Models\Servicio;
use App\Models\ServicioDetalle;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$servicio = Servicio::all();
        //$servicios = Servicio::orderBy('id', 'desc')->get();
        //$serviciodetalle = Servicio::all();
        $servicios = Servicio::with(
            [
                'proveedor:id,razon_social',
                'servicio_detalle:id,descripcion',
                'ubicacion:id,nombre',
            ])
        ->orderBy('id', 'desc')
        ->paginate(10);
        return Inertia::render('Servicio/Index', compact('servicios'));
        //return response()->json( ['servicio' => $servicio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedProveedor = Proveedor::getFormattedForDropdown();
        $formattedUbicacion = Ubicacion::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('Servicio/Create', ['ListaProveedor' => $formattedProveedor, 'ListaUbicacion' => $formattedUbicacion, 'ListaServicio_detalle' => $formattedServicioDetalle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $servicio = Servicio::create($data);
        //return to_route('servicio');
        if ($servicio) {
            return response()->json([
                'message' => 'Servicio creado exitosamente',
                'data' => $servicio
            ], 201); // 201 Created
        } else {
            return response()->json([
                'message' => 'Error al crear el servicio'
            ], 500); // 500 Internal Server Error
        }
    }

    public function servicioList(Request $request)
    {
        $data = $request->all();
        $servicioList = Servicio::getFormattedForDropdownPrecio($data['proveedor_id']);
        return response()->json($servicioList);
    }

    public function servicioParaCotizaciones(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $proveedorCategoriaId = $data['proveedor_categoria_id'];
        $proveedorId = $data['proveedor_id'];
        $servicioId = $data['servicio_id'];

        $response = Servicio::with([
            'precios',
            'servicioDetalles' => function($query) use ($proveedorCategoriaId) {
                $query->where('proveedor_categoria_id', $proveedorCategoriaId)
                    ->select('id', 'descripcion', 'proveedor_categoria_id')
                    ->with([
                        'proveedor_categoria' => function($query) use ($proveedorCategoriaId) {
                            $query->where('id', $proveedorCategoriaId)
                            ->select('id', 'nombre'); // Solo los campos necesarios
                        }
                    ]);
            },
            'proveedor' => function($query) {
                $query->select('id', 'ruc', 'razon_social', 'proveedor_categoria_id')
                    //->where('proveedor_categoria_id', 2) // unicamente categorias de hoteles
                    ->with('catalogoHabitaciones');
            }
        ])
        ->where('proveedor_id', $proveedorId)
        ->where('id', $servicioId)
        ->get();

        return response()->json([
            'servicio' => $response
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        // return Inertia::render('Servicio/Show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        $formattedProveedor = Proveedor::getFormattedForDropdown();
        $formattedUbicacion = Ubicacion::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('Servicio/Edit', ['servicio' => $servicio, 'ListaProveedor' => $formattedProveedor, 'ListaUbicacion' => $formattedUbicacion, 'ListaServicio_detalle' => $formattedServicioDetalle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->all();
        $servicio->update($data);
        return Inertia::render('Servicio/Edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEstado($id)
    {
        try {
            // Encuentra el servicio por su ID
            Servicio::where('proveedor_id', $id)->update(['estado_activo' => 0]);
    
            return response()->json(['message' => 'Servicio desactivado con éxito.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al desactivar el servicio: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return to_route('servicio');
    }
}
