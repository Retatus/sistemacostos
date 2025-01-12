<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServicioClase\StoreRequest;
use App\Models\ServicioClase;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ServicioClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$servicioclase = ServicioClase::all();
        $servicioclases = ServicioClase::orderBy('id', 'desc')->get();
        return Inertia::render('ServicioClase/Index', compact('servicioclases'));
        //return response()->json( ['servicioclase' => $servicioclase]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ServicioClase/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ServicioClase::create($data);
        return to_route('servicio_clase');
    }

    public function storemodal(StoreRequest $request)
    {
        $data = $request->all();
        ServicioClase::create($data);
        $dataResponse = ServicioClase::getFormattedForDropdown();
        //return response()->json(ServicioClase::orderBy('id', 'desc')->get());
        return response()->json($dataResponse);
        //return to_route('servicio_clase');
    }
    /**
     * Display the specified resource.
     */
    public function show(ServicioClase $servicioClase)
    {
        // return Inertia::render('ServicioClase/Show', compact('servicioclase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicioClase $servicioClase)
    {
        return Inertia::render('ServicioClase/Edit', compact('servicioClase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicioClase $servicioClase)
    {
        $data = $request->all();
        $servicioClase->update($data);
        return Inertia::render('ServicioClase/Edit', compact('servicioClase'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicioClase $servicioClase)
    {
        $servicioClase->delete();
        return to_route('servicio_clase');
    }
}
