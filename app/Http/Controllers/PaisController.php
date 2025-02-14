<?php

namespace App\Http\Controllers;
use App\Http\Requests\Pais\StoreRequest;
use App\Models\Pais;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$pais = Pais::all();
        $paiss = Pais::orderBy('id', 'desc')->get();
        return Inertia::render('Pais/Index', compact('paiss'));
        //return response()->json( ['pais' => $pais]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pais/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Pais::create($data);
        return to_route('pais');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pais $pais)
    {
        // return Inertia::render('Pais/Show', compact('pais'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pais $pais)
    {
        return Inertia::render('Pais/Edit', compact('pais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pais $pais)
    {
        $data = $request->all();
        $pais->update($data);
        return Inertia::render('Pais/Edit', compact('pais'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pais $pais)
    {
        $pais->delete();
        return to_route('pais');
    }
}
