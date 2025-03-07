<?php

namespace App\Http\Controllers;
use App\Http\Requests\Precio\StoreRequest;
use App\Models\Precio;
use App\Models\Servicio;
use App\Models\ServicioClase;
use App\Models\TipoPasajero;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$precio = Precio::all();
        //$precios = Precio::orderBy('id', 'desc')->get();
        $precios = Precio::with(
            [
                'servicio.servicio_detalle:id,descripcion',
                'tipo_pasajero:id,nombre',
                'servicio_clase:id,nombre',
            ])
        ->orderBy('id', 'desc')->get();
        //dd($precios);
        return Inertia::render('Precio/Index', compact('precios'));
        //return response()->json( ['precio' => $precio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedTipoPasajeros = TipoPasajero::getFormattedForDropdown();
        $formattedServiciosClase = ServicioClase::getFormattedForDropdown();
        $formattedServicios = Servicio::with(
            [
                'proveedor:id,razon_social',
                'servicio_detalle:id,descripcion'
            ])
        ->where('estado_activo', 1)
        ->orderBy('id', 'desc') 
        ->get();
//dd($formattedServicios->toJson());
        // $formattedServicios = Servicio::select('id', 'monto', 'moneda')
        // ->with(['servicio_detalle' => function ($query) {
        //     $query->select('id', 'descripcion', 'servicio_clase_id');
        // }])
        // ->orderBy('id', 'desc')
        // ->get();

        
        return Inertia::render('Precio/Create', 
        [
            'tipopasajeros' => $formattedTipoPasajeros,
            'servicios_clases' => $formattedServiciosClase,
            'servicios' => $formattedServicios,
        ]); //compact('proveedorcategorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Precio::create($data);
        return to_route('precio');
    }

    /**
     * Display the specified resource.
     */
    public function show(Precio $precio)
    {
        // return Inertia::render('Precio/Show', compact('precio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Precio $precio)
    {
        $formattedTipoPasajeros = TipoPasajero::getFormattedForDropdown();
        $formattedServiciosClase = ServicioClase::getFormattedForDropdown();
        $formattedServicios = Servicio::with(
            [
                'proveedor:id,razon_social',
                'servicio_detalle:id,descripcion'
            ])
        ->where('estado_activo', 1)
        ->orderBy('id', 'desc') 
        ->get();
        
        return Inertia::render('Precio/Edit', 
        [
            'tipopasajeros' => $formattedTipoPasajeros,
            'servicios' => $formattedServicios,
            'servicios_clases' => $formattedServiciosClase,
            'precio' => $precio
        ]); //compact('proveedorcategorias'));
        //return Inertia::render('Precio/Edit', compact('precio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Precio $precio)
    {
        $data = $request->all();
        $precio->update($data);
        return Inertia::render('Precio/Edit', compact('precio'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Precio $precio)
    {
        $precio->delete();
        return to_route('precio');
    }
}
