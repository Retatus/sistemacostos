<?php

namespace App\Http\Controllers;
use App\Http\Requests\ClaseServicio\StoreRequest;
use App\Models\ClaseServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ClaseServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$claseservicio = ClaseServicio::all();
        $claseservicios = ClaseServicio::orderBy('id', 'desc')->get();
        return Inertia::render('ClaseServicio/Index', compact('claseservicios'));
        //return response()->json( ['claseservicio' => $claseservicio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ClaseServicio/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        ClaseServicio::create($data);
        return to_route('clase_servicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClaseServicio $claseServicio)
    {
        // return Inertia::render('ClaseServicio/Show', compact('claseservicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClaseServicio $claseServicio)
    {
        return Inertia::render('ClaseServicio/Edit', compact('claseServicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, ClaseServicio $claseServicio)
    {
        $data = $request->all();
        $claseServicio->update($data);
        return to_route('clase_servicio');
        //return Inertia::render('ClaseServicio/Edit', compact('claseServicio'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClaseServicio $claseServicio)
    {
        $claseServicio->delete();
        return to_route('clase_servicio');
    }
}
