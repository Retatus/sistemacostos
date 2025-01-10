<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServicioDetalle\StoreRequest;
use App\Models\Costos;
use App\Models\Destino;
use App\Models\DistribucionVenta;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ServicioDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$serviciodetalle = ServicioDetalle::all();
        $serviciodetalles = ServicioDetalle::orderBy('id', 'desc')->get();
        return Inertia::render('ServicioDetalle/Index', compact('serviciodetalles'));
        //return response()->json( ['serviciodetalle' => $serviciodetalle]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedCostos = Costos::getFormattedForDropdown();
        $formattedDestinos = Destino::getFormattedForDropdown();
        $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        return Inertia::render('ServicioDetalle/Create', ['categoriaCostos' => $formattedCostos, 'categoriaDestinos' => $formattedDestinos, 'categoriaDistribuciones' => $formattedDistribuciones]); //compact('proveedorcategorias' => $formattedCategorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ServicioDetalle::create($data);
        return to_route('servicio_detalle');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServicioDetalle $servicioDetalle)
    {
        // return Inertia::render('ServicioDetalle/Show', compact('serviciodetalle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicioDetalle $servicioDetalle)
    {
        $formattedCostos = Costos::getFormattedForDropdown();
        $formattedDestinos = Destino::getFormattedForDropdown();
        $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        return Inertia::render('ServicioDetalle/Edit', [ 'servicioDetalle' => $servicioDetalle,'categoriaCostos' => $formattedCostos, 'categoriaDestinos' => $formattedDestinos, 'categoriaDistribuciones' => $formattedDistribuciones]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicioDetalle $servicioDetalle)
    {
        $data = $request->all();
        $servicioDetalle->update($data);
        return Inertia::render('ServicioDetalle/Edit', compact('servicioDetalle'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicioDetalle $servicioDetalle)
    {
        $servicioDetalle->delete();
        return to_route('servicio_detalle');
    }
}
