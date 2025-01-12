<?php

namespace App\Http\Controllers;
use App\Http\Requests\proveedor\StoreRequest;
use App\Models\Costo;
use App\Models\Destino;
use App\Models\DistribucionVenta;
use App\Models\ProveedorCategoria;
use App\Models\proveedor;
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
        $proveedors = Proveedor::with('categoria:id,nombre') 
        ->orderBy('id', 'desc') 
        ->get();
        //dd($proveedors);
        return Inertia::render('proveedor/Index', compact('proveedors'));
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
        ['proveedorcategorias' => $formattedCategorias,
         'categoriaCostos' => $formattedCostos,
         'categoriaDestinos' => $formattedDestinos,
         'categoriaDistribuciones' => $formattedDistribuciones,
         'ListaServicio_clase' => $formattedServicioClase,
         'ListaServicio_detalle' => $formattedServicioDetalle]
    ); //compact('proveedorcategorias'));
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
        $categoria = ProveedorCategoria::orderBy('id', 'desc')->get();
        $formattedCategorias = $categoria->map(function ($categoria) {
            return [
                'value' => $categoria->id,
                'label' => $categoria->nombre,
            ];
        });
        return Inertia::render('proveedor/Edit', ['proveedor' => $proveedor, 'proveedorcategorias' => $formattedCategorias]); //compact('proveedorcategorias')); compact('proveedor'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(proveedor $proveedor)
    {
        $proveedor->delete();
        return to_route('proveedor');
    }
}
