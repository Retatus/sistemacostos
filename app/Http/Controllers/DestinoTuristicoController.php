<?php

namespace App\Http\Controllers;
use App\Http\Requests\DestinoTuristico\StoreRequest;
use App\Models\DestinoTuristico;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DestinoTuristicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$destinoturistico = DestinoTuristico::all();
        $destinoturisticos = DestinoTuristico::orderBy('id', 'desc')->get();
        return Inertia::render('DestinoTuristico/Index', compact('destinoturisticos'));
        //return response()->json( ['destinoturistico' => $destinoturistico]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('DestinoTuristico/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        DestinoTuristico::create($data);
        return to_route('destino_turistico');
    }

    /**
     * Display the specified resource.
     */
    public function show(DestinoTuristico $destinoTuristico)
    {
        // return Inertia::render('DestinoTuristico/Show', compact('destinoTuristico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinoTuristico $destinoTuristico)
    {
        return Inertia::render('DestinoTuristico/Edit', compact('destinoTuristico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestinoTuristico $destinoTuristico)
    {
        $data = $request->all();
        $destinoTuristico->update($data);
        return Inertia::render('DestinoTuristico/Edit', compact('destinoTuristico'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinoTuristico $destinoTuristico)
    {
        $destinoTuristico->delete();
        return to_route('destino_turistico');
    }
}
