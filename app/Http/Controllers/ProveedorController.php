<?php

namespace App\Http\Controllers;
use App\Http\Requests\proveedor\StoreRequest;
use App\Models\Costo;
use App\Models\Destino;
use App\Models\DistribucionVenta;
use App\Models\ProveedorCategoria;
use App\Models\proveedor;
use App\Models\Servicio;
use App\Models\ServicioClase;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$proveedor = proveedor::all();
        //$proveedors = proveedor::orderBy('id', 'desc')->get();
        $proveedors = Proveedor::with('categoria:id,nombre')->where('estado_activo', 1)->orderBy('id', 'desc')->paginate(10);
        //dd($proveedors);
        return Inertia::render('proveedor/Index', ['proveedors' => $proveedors]);
        //return response()->json( ['proveedor' => $proveedor]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedCostos = Costo::getFormattedForDropdown();
        $formattedDestinos = Destino::getFormattedForDropdown();
        $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        $formattedServicioClase = ServicioClase::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('proveedor/CreateProveedor', 
        [
            'proveedorcategorias' => $formattedCategorias,
            'categoriaCostos' => $formattedCostos,
            'categoriaDestinos' => $formattedDestinos,
            'categoriaDistribuciones' => $formattedDistribuciones,
            'ListaServicio_clase' => $formattedServicioClase,
            'ListaServicio_detalle' => $formattedServicioDetalle
        ]); //compact('proveedorcategorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $proveedor = proveedor::create($data);
        //return to_route('proveedor');
        return response()->json($proveedor);
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
        $servicio = Servicio::where('proveedor_id', $proveedor->id)->get();
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedCostos = Costo::getFormattedForDropdown();
        $formattedDestinos = Destino::getFormattedForDropdown();
        $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        $formattedServicioClase = ServicioClase::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('proveedor/EditProveedor',
        [
            'proveedor_edit' => $proveedor,
            'servicio_edit' => $servicio,
            'proveedorcategorias' => $formattedCategorias,
            'categoriaCostos' => $formattedCostos,
            'categoriaDestinos' => $formattedDestinos,
            'categoriaDistribuciones' => $formattedDistribuciones,
            'ListaServicio_clase' => $formattedServicioClase,
            'ListaServicio_detalle' => $formattedServicioDetalle
        ]); //compact('proveedorcategorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, proveedor $proveedor)
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
