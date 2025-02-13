<?php

namespace App\Http\Controllers;
use App\Http\Requests\Itinerario\StoreRequest;
use App\Models\Itinerario;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ItinerarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$itinerario = Itinerario::all();
        $itinerarios = Itinerario::orderBy('id', 'desc')->get();
        return Inertia::render('Itinerario/Index', compact('itinerarios'));
        //return response()->json( ['itinerario' => $itinerario]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Itinerario/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Itinerario::create($data);
        return to_route('itinerario');
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerario $itinerario)
    {
        // return Inertia::render('Itinerario/Show', compact('itinerario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itinerario $itinerario)
    {
        return Inertia::render('Itinerario/Edit', compact('itinerario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itinerario $itinerario)
    {
        $data = $request->all();
        $itinerario->update($data);
        return Inertia::render('Itinerario/Edit', compact('itinerario'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerario $itinerario)
    {
        $itinerario->delete();
        return to_route('itinerario');
    }
}
