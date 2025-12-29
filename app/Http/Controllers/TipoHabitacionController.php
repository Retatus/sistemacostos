<?php

namespace App\Http\Controllers;
use App\Http\Requests\TipoHabitacion\StoreRequest;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TipoHabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tipo_habitacion = TipoHabitacion::all();
        $tipohabitacions = TipoHabitacion::orderBy('id', 'desc')->get();
        return Inertia::render('TipoHabitacion/Index', compact('tipohabitacions'));
        //return response()->json( ['tipo_habitacion' => $tipo_habitacion]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoHabitacion/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TipoHabitacion::create($data);
        return to_route('tipo_habitacion');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoHabitacion $tipoHabitacion)
    {
        // return Inertia::render('TipoHabitacion/Show', compact('tipo_habitacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoHabitacion $tipoHabitacion)
    {
        return Inertia::render('TipoHabitacion/Edit', compact('tipo_habitacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoHabitacion $tipoHabitacion)
    {
        $data = $request->all();
        $tipo_habitacion->update($data);
        return Inertia::render('TipoHabitacion/Edit', compact('tipo_habitacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoHabitacion $tipoHabitacion)
    {
        $tipo_habitacion->delete();
        return to_route('tipo_habitacion');
    }
}
