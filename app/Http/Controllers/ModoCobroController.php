<?php

namespace App\Http\Controllers;
use App\Http\Requests\ModoCobro\StoreRequest;
use App\Models\ModoCobro;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ModoCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$modocobro = ModoCobro::all();
        $modocobros = ModoCobro::orderBy('id', 'desc')->get();
        return Inertia::render('ModoCobro/Index', compact('modocobros'));
        //return response()->json( ['modocobro' => $modocobro]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ModoCobro/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ModoCobro::create($data);
        return to_route('modo_cobro');
    }

    /**
     * Display the specified resource.
     */
    public function show(ModoCobro $modoCobro)
    {
        // return Inertia::render('ModoCobro/Show', compact('modocobro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModoCobro $modoCobro)
    {
        return Inertia::render('ModoCobro/Edit', compact('modoCobro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModoCobro $modoCobro)
    {
        $data = $request->all();
        $modoCobro->update($data);
        return Inertia::render('ModoCobro/Edit', compact('modoCobro'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModoCobro $modoCobro)
    {
        $modoCobro->delete();
        return to_route('modo_cobro');
    }
}
