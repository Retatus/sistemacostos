<?php

namespace App\Http\Controllers;
use App\Http\Requests\DestinoTuristico\StoreRequest;
use App\Models\DestinoTuristico;
use App\Models\Itinerario;
use App\Models\Pais;
use App\Models\proveedor;
use App\Models\ProveedorCategoria;
use App\Models\Servicio;
use App\Models\ServicioClase;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DestinoTuristicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$destinoturistico = DestinoTuristico::all();
        $destinoturisticos = DestinoTuristico::orderBy('id', 'desc')->get();
        return Inertia::render('DestinoTuristico/Index', compact('destinoturisticos'));
        //return response()->json( ['destinoturistico' => $destinoturistico]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return Inertia::render('DestinoTuristico/Create');
        $formattedPaises = Pais::getFormattedForDropdown();
        $formattedItinerarios = Itinerario::getFormattedForDropdown();
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedProveedores = proveedor::getFormattedForDropdown();
        // $formattedCostos = Costo::getFormattedForDropdown();
        // $formattedDestinos = Destino::getFormattedForDropdown();
        // $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        $formattedServicio = Servicio::getFormattedForDropdown();
        $formattedServicioClase = ServicioClase::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('DestinoTuristico/CreateDestinoTuristico', 
        [
            'ListaPaises' => $formattedPaises,
            'ListaItinerarios' => $formattedItinerarios,
            'ListaProveedorCategorias' => $formattedCategorias,
            'ListaProveedor' =>  $formattedProveedores,
            // 'categoriaDestinos' => $formattedDestinos,
            // 'categoriaDistribuciones' => $formattedDistribuciones,
            'ListaServicio' => $formattedServicio,
        ]);
        return Inertia::render('DestinoTuristico/CreateDestinoTuristico');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        DestinoTuristico::create($data);
        return to_route('destino_turistico');
    }

    public function DestinoCategories(Request $request)
    {
        $data = $request->all();
        $servicioDetalle = ServicioDetalle::getFormattedForDropdown($data['proveedor_categoria_id']);
        return response()->json($servicioDetalle);
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
        return Inertia::render('DestinoTuristico/Edit', compact('destinoTuristico'));
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
