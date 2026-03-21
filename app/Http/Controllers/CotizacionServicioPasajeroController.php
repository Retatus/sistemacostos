<?php

namespace App\Http\Controllers;
use App\Http\Requests\CotizacionServicioPasajero\StoreRequest;
use App\Models\CotizacionServicioPasajero;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CotizacionServicioPasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cotizacionserviciopasajero = CotizacionServicioPasajero::all();
        $cotizacionserviciopasajeros = CotizacionServicioPasajero::orderBy('id', 'desc')->get();
        return Inertia::render('CotizacionServicioPasajero/Index', compact('cotizacionserviciopasajeros'));
        //return response()->json( ['cotizacionserviciopasajero' => $cotizacionserviciopasajero]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CotizacionServicioPasajero/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        CotizacionServicioPasajero::create($data);
        return to_route('cotizacion_servicio_pasajero');
    }

    /**
     * Display the specified resource.
     */
    public function show(CotizacionServicioPasajero $cotizacionServicioPasajero)
    {
        // return Inertia::render('CotizacionServicioPasajero/Show', compact('cotizacionserviciopasajero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionServicioPasajero $cotizacionServicioPasajero)
    {
        return Inertia::render('CotizacionServicioPasajero/Edit', compact('cotizacionserviciopasajero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionServicioPasajero $cotizacionServicioPasajero)
    {
        $data = $request->all();
        $cotizacionServicioPasajero->update($data);
        return Inertia::render('CotizacionServicioPasajero/Edit', compact('cotizacionServicioPasajero'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionServicioPasajero $cotizacionServicioPasajero)
    {
        $cotizacionServicioPasajero->delete();
        return to_route('cotizacion_servicio_pasajero');
    }
}
