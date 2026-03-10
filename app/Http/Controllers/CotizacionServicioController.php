<?php

namespace App\Http\Controllers;
use App\Http\Requests\CotizacionServicio\StoreRequest;
use App\Models\CotizacionServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CotizacionServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cotizacionservicio = CotizacionServicio::all();
        $cotizacionservicios = CotizacionServicio::orderBy('id', 'desc')->get();
        return Inertia::render('CotizacionServicio/Index', compact('cotizacionservicios'));
        //return response()->json( ['cotizacionservicio' => $cotizacionservicio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CotizacionServicio/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        CotizacionServicio::create($data);
        return to_route('cotizacion_servicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(CotizacionServicio $cotizacionServicio)
    {
        // return Inertia::render('CotizacionServicio/Show', compact('cotizacionservicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionServicio $cotizacionServicio)
    {
        return Inertia::render('CotizacionServicio/Edit', compact('cotizacionServicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionServicio $cotizacionServicio)
    {
        $data = $request->all();
        $cotizacionServicio->update($data);
        return Inertia::render('CotizacionServicio/Edit', compact('cotizacionServicio'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionServicio $cotizacionServicio)
    {
        $cotizacionServicio->delete();
        return to_route('cotizacion_servicio');
    }
}
