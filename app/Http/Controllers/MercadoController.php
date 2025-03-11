<?php

namespace App\Http\Controllers;
use App\Http\Requests\Mercado\StoreRequest;
use App\Models\Mercado;
use Illuminate\Http\Request;
use Inertia\Inertia;
class MercadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$mercado = Mercado::all();
        $mercados = Mercado::orderBy('id', 'desc')->get();
        return Inertia::render('Mercado/Index', compact('mercados'));
        //return response()->json( ['mercado' => $mercado]);
    }

    public function selectOptions()
    {
        $categories = Mercado::getFormattedForDropdown();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Mercado/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Mercado::create($data);
        return to_route('mercado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mercado $mercado)
    {
        // return Inertia::render('Mercado/Show', compact('mercado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mercado $mercado)
    {
        return Inertia::render('Mercado/Edit', compact('mercado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mercado $mercado)
    {
        $data = $request->all();
        $mercado->update($data);
        return Inertia::render('Mercado/Edit', compact('mercado'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mercado $mercado)
    {
        $mercado->delete();
        return to_route('mercado');
    }
}
