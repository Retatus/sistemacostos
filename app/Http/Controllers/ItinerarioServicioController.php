<?php

namespace App\Http\Controllers;
use App\Http\Requests\ItinerarioServicio\StoreRequest;
use App\Models\ItinerarioServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ItinerarioServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$itinerarioservicio = ItinerarioServicio::all();
        $itinerarioservicios = ItinerarioServicio::orderBy('id', 'desc')->get();
        return Inertia::render('ItinerarioServicio/Index', compact('itinerarioservicios'));
        //return response()->json( ['itinerarioservicio' => $itinerarioservicio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ItinerarioServicio/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ItinerarioServicio::create($data);
        return to_route('itinerario_servicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItinerarioServicio $itinerarioServicio)
    {
        // return Inertia::render('ItinerarioServicio/Show', compact('itinerarioservicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItinerarioServicio $itinerarioServicio)
    {
        return Inertia::render('ItinerarioServicio/Edit', compact('itinerarioServicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItinerarioServicio $itinerarioServicio)
    {
        $data = $request->all();
        $itinerarioServicio->update($data);
        return Inertia::render('ItinerarioServicio/Edit', compact('itinerarioServicio'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItinerarioServicio $itinerarioServicio)
    {
        $itinerarioServicio->delete();
        return to_route('itinerarioServicio');
    }
}
