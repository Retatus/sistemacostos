<?php

namespace App\Http\Controllers;
use App\Http\Requests\Servicio\StoreRequest;
use App\Models\proveedor;
use App\Models\Servicio;
use App\Models\ServicioClase;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$servicio = Servicio::all();
        $servicios = Servicio::orderBy('id', 'desc')->get();
        //$serviciodetalle = Servicio::all();
        $serviciodetalles = Servicio::with(
            [
                'proveedor:id,nombre',
                'servicio_detalle:id,nombre',
                'servicio_clase:id,nombre',
            ])
        ->orderBy('id', 'desc')
        ->get();
        return Inertia::render('Servicio/Index', compact('servicios'));
        //return response()->json( ['servicio' => $servicio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedProveedor = Proveedor::getFormattedForDropdown();
        $formattedServicioClase = ServicioClase::getFormattedForDropdown();
        $formattedServicioDetalle = ServicioDetalle::getFormattedForDropdown();
        return Inertia::render('Servicio/Create', ['ListaProveedor' => $formattedProveedor, 'ListaServicio_clase' => $formattedServicioClase, 'ListaServicio_detalle' => $formattedServicioDetalle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Servicio::create($data);
        return to_route('servicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        // return Inertia::render('Servicio/Show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        return Inertia::render('Servicio/Edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->all();
        $servicio->update($data);
        return Inertia::render('Servicio/Edit', compact('servicio'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return to_route('servicio');
    }
}
