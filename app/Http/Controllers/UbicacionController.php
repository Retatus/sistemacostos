<?php

namespace App\Http\Controllers;
use App\Http\Requests\Ubicacion\StoreRequest;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$ubicacion = Ubicacion::all();
        $ubicacions = Ubicacion::orderBy('id', 'desc')->get();
        return Inertia::render('Ubicacion/Index', compact('ubicacions'));
        //return response()->json( ['ubicacion' => $ubicacion]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Ubicacion/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Ubicacion::create($data);
        return to_route('ubicacion');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        // return Inertia::render('Ubicacion/Show', compact('ubicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacion)
    {
        return Inertia::render('Ubicacion/Edit', compact('ubicacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        $data = $request->all();
        $ubicacion->update($data);
        return Inertia::render('Ubicacion/Edit', compact('ubicacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return to_route('ubicacion');
    }
}
