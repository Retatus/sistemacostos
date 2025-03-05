<?php

namespace App\Http\Controllers;
use App\Http\Requests\Pasajero\StoreRequest;
use App\Models\Pasajero;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$pasajero = Pasajero::all();
        $pasajeros = Pasajero::orderBy('id', 'desc')->get();
        return Inertia::render('Pasajero/Index', compact('pasajeros'));
        //return response()->json( ['pasajero' => $pasajero]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pasajero/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Pasajero::create($data);
        return to_route('pasajero');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasajero $pasajero)
    {
        // return Inertia::render('Pasajero/Show', compact('pasajero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasajero $pasajero)
    {
        return Inertia::render('Pasajero/Edit', compact('pasajero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasajero $pasajero)
    {
        $data = $request->all();
        $pasajero->update($data);
        return Inertia::render('Pasajero/Edit', compact('pasajero'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasajero $pasajero)
    {
        $pasajero->delete();
        return to_route('pasajero');
    }
}
