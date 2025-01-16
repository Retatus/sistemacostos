<?php

namespace App\Http\Controllers;
use App\Http\Requests\Destino\StoreRequest;
use App\Models\Destino;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$destino = Destino::all();
        $destinos = Destino::orderBy('id', 'desc')->get();
        return Inertia::render('Destino/Index', compact('destinos'));
        //return response()->json( ['destino' => $destino]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Destino/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Destino::create($data);
        return to_route('destino');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destino $destino)
    {
        // return Inertia::render('Destino/Show', compact('destino'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destino $destino)
    {
        return Inertia::render('Destino/Edit', compact('destino'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destino $destino)
    {
        $data = $request->all();
        $destino->update($data);
        return Inertia::render('Destino/Edit', compact('destino'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destino $destino)
    {
        $destino->delete();
        return to_route('destino');
    }
}
