<?php

namespace App\Http\Controllers;
use App\Http\Requests\TipoDocumento\StoreRequest;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TipoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tipodocumento = TipoDocumento::all();
        $tipodocumentos = TipoDocumento::orderBy('id', 'desc')->get();
        return Inertia::render('TipoDocumento/Index', compact('tipodocumentos'));
        //return response()->json( ['tipodocumento' => $tipodocumento]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoDocumento/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TipoDocumento::create($data);
        return to_route('tipodocumento');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoDocumento $tipoDocumento)
    {
        // return Inertia::render('TipoDocumento/Show', compact('tipodocumento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoDocumento $tipoDocumento)
    {
        return Inertia::render('TipoDocumento/Edit', compact('tipodocumento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoDocumento $tipoDocumento)
    {
        $data = $request->all();
        $tipodocumento->update($data);
        return Inertia::render('TipoDocumento/Edit', compact('tipodocumento'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoDocumento $tipoDocumento)
    {
        $tipodocumento->delete();
        return to_route('tipodocumento');
    }
}
