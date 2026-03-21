<?php

namespace App\Http\Controllers;
use App\Http\Requests\CotizacionDia\StoreRequest;
use App\Models\CotizacionDia;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CotizacionDiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cotizaciondias = CotizacionDia::all();
        $cotizaciondias = CotizacionDia::orderBy('id', 'desc')->get();
        return Inertia::render('CotizacionDia/Index', compact('cotizaciondias'));
        //return response()->json( ['cotizaciondias' => $cotizaciondias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CotizacionDia/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        CotizacionDia::create($data);
        return to_route('cotizacion_dia');
    }

    /**
     * Display the specified resource.
     */
    public function show(CotizacionDia $cotizacionDia)
    {
        // return Inertia::render('CotizacionDia/Show', compact('cotizaciondias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionDia $cotizacionDia)
    {
        return Inertia::render('CotizacionDia/Edit', compact('cotizacionDia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionDia $cotizacionDia)
    {
        $data = $request->all();
        $cotizacionDia->update($data);
        return Inertia::render('CotizacionDia/Edit', compact('cotizacionDia'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionDia $cotizacionDia)
    {
        $cotizacionDia->delete();
        return to_route('cotizacion_dia');
    }
}
