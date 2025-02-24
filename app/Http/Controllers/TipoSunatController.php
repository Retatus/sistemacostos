<?php

namespace App\Http\Controllers;
use App\Http\Requests\TipoSunat\StoreRequest;
use App\Models\TipoSunat;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TipoSunatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tiposunat = TipoSunat::all();
        $tiposunats = TipoSunat::orderBy('id', 'desc')->get();
        return Inertia::render('TipoSunat/Index', compact('tiposunats'));
        //return response()->json( ['tiposunat' => $tiposunat]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoSunat/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TipoSunat::create($data);
        return to_route('tipo_sunat');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoSunat $tipoSunat)
    {
        // return Inertia::render('TipoSunat/Show', compact('tiposunat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoSunat $tipoSunat)
    {
        return Inertia::render('TipoSunat/Edit', compact('tipoSunat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoSunat $tipoSunat)
    {
        $data = $request->all();
        $tipoSunat->update($data);
        return Inertia::render('TipoSunat/Edit', compact('tipoSunat'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoSunat $tipoSunat)
    {
        $tipoSunat->delete();
        return to_route('tipoSunat');
    }
}
