<?php

namespace App\Http\Controllers;
use App\Http\Requests\TipoPasajero\StoreRequest;
use App\Models\TipoPasajero;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TipoPasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tipopasajero = TipoPasajero::all();
        $tipopasajeros = TipoPasajero::orderBy('id', 'desc')->get();
        return Inertia::render('TipoPasajero/Index', compact('tipopasajeros'));
        //return response()->json( ['tipopasajero' => $tipopasajero]);
    }

    public function selectOptions()
    {
        $categories = TipoPasajero::getFormattedForDropdown();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoPasajero/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TipoPasajero::create($data);
        return to_route('tipo_pasajero');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoPasajero $tipoPasajero)
    {
        // return Inertia::render('TipoPasajero/Show', compact('tipoPasajero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoPasajero $tipoPasajero)
    {
        return Inertia::render('TipoPasajero/Edit', compact('tipoPasajero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoPasajero $tipoPasajero)
    {
        $data = $request->all();
        $tipoPasajero->update($data);
        return Inertia::render('TipoPasajero/Edit', compact('tipoPasajero'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoPasajero $tipoPasajero)
    {
        $tipoPasajero->delete();
        return to_route('tipoPasajero');
    }
}
