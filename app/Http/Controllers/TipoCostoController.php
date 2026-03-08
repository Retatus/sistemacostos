<?php

namespace App\Http\Controllers;
use App\Http\Requests\TipoCosto\StoreRequest;
use App\Models\TipoCosto;
use Illuminate\Http\Request;
use Inertia\Inertia;
class TipoCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tipocosto = TipoCosto::all();
        $tipocostos = TipoCosto::orderBy('id', 'desc')->get();
        return Inertia::render('TipoCosto/Index', compact('tipocostos'));
        //return response()->json( ['tipocosto' => $tipocosto]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TipoCosto/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TipoCosto::create($data);
        return to_route('tipo_costo');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoCosto $tipoCosto)
    {
        // return Inertia::render('TipoCosto/Show', compact('tipocosto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoCosto $tipoCosto)
    {
        return Inertia::render('TipoCosto/Edit', compact('tipoCosto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoCosto $tipoCosto)
    {
        $data = $request->all();
        $tipoCosto->update($data);
        return Inertia::render('TipoCosto/Edit', compact('tipoCosto'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoCosto $tipoCosto)
    {
        $tipoCosto->delete();
        return to_route('tipo_costo');
    }
}
