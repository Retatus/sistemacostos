<?php

namespace App\Http\Controllers;
use App\Http\Requests\ItinerarioDestino\StoreRequest;
use App\Models\ItinerarioDestino;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ItinerarioDestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$itinerariodestino = ItinerarioDestino::all();
        $itinerariodestinos = ItinerarioDestino::orderBy('id', 'desc')->paginate(10); //->get();
        return Inertia::render('ItinerarioDestino/Index', compact('itinerariodestinos'));
        //return response()->json( ['itinerariodestino' => $itinerariodestino]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ItinerarioDestino/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ItinerarioDestino::create($data);
        return to_route('itinerario_destino');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItinerarioDestino $itinerarioDestino)
    {
        // return Inertia::render('ItinerarioDestino/Show', compact('itinerariodestino'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItinerarioDestino $itinerarioDestino)
    {
        return Inertia::render('ItinerarioDestino/Edit', compact('itinerarioDestino'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItinerarioDestino $itinerarioDestino)
    {
        $data = $request->all();
        $itinerarioDestino->update($data);
        return Inertia::render('ItinerarioDestino/Edit', compact('itinerarioDestino'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItinerarioDestino $itinerarioDestino)
    {
        $itinerarioDestino->delete();
        return to_route('itinerario_destino');
    }
}
