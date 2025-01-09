<?php

namespace App\Http\Controllers;
use App\Http\Requests\Costos\StoreRequest;
use App\Models\Costos;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CostosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$costos = Costos::all();
        $costoss = Costos::orderBy('id', 'desc')->get();
        return Inertia::render('Costos/Index', compact('costoss'));
        //return response()->json( ['costos' => $costos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Costos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Costos::create($data);
        return to_route('costo');
    }

    /**
     * Display the specified resource.
     */
    public function show(Costos $costos)
    {
        // return Inertia::render('Costos/Show', compact('costos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Costos $costos)
    {
        return Inertia::render('Costos/Edit', compact('costos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Costos $costos)
    {
        $data = $request->all();
        $costos->update($data);
        return Inertia::render('Costos/Edit', compact('costos'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costos $costos)
    {
        $costos->delete();
        return to_route('costo');
    }
}
