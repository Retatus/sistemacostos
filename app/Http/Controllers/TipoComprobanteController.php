<?php

namespace App\Http\Controllers;
use App\Http\Requests\TipoComprobante\StoreRequest;
use App\Models\TipoComprobante;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TipoComprobanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tipocomprobante = TipoComprobante::all();
        $tipocomprobantes = TipoComprobante::orderBy('id', 'desc')->get();
        return Inertia::render('TipoComprobante/Index', compact('tipocomprobantes'));
        //return response()->json( ['tipocomprobante' => $tipocomprobante]);
    }

    public function selectOptions()
    {
        $categories = TipoComprobante::getFormattedForDropdown();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoComprobante/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TipoComprobante::create($data);
        return to_route('tipo_comprobante');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoComprobante $tipoComprobante)
    {
        // return Inertia::render('TipoComprobante/Show', compact('tipocomprobante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoComprobante $tipoComprobante)
    {
        return Inertia::render('TipoComprobante/Edit', compact('tipoComprobante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoComprobante $tipoComprobante)
    {
        $data = $request->all();
        $tipoComprobante->update($data);
        return Inertia::render('TipoComprobante/Edit', compact('tipoComprobante'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoComprobante $tipoComprobante)
    {
        $tipoComprobante->delete();
        return to_route('tipoComprobante');
    }
}
