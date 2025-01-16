<?php

namespace App\Http\Controllers;
use App\Http\Requests\Costo\StoreRequest;
use App\Models\Costo;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$costo = Costo::all();
        $costos = Costo::orderBy('id', 'desc')->get();
        return Inertia::render('Costo/Index', compact('costos'));
        //return response()->json( ['costo' => $costo]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Costo/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Costo::create($data);
        return to_route('costo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Costo $costo)
    {
        // return Inertia::render('Costo/Show', compact('costo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Costo $costo)
    {
        return Inertia::render('Costo/Edit', compact('costo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Costo $costo)
    {
        $data = $request->all();
        $costo->update($data);
        return Inertia::render('Costo/Edit', compact('costo'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costo $costo)
    {
        $costo->delete();
        return to_route('costo');
    }
}
