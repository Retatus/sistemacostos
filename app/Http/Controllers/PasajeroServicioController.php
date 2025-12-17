<?php

namespace App\Http\Controllers;
use App\Http\Requests\PasajeroServicio\StoreRequest;
use App\Models\ItinerarioServicio;
use App\Models\Pasajero;
use App\Models\PasajeroServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PasajeroServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$pasajeroservicio = PasajeroServicio::all();
        $pasajeroservicios = PasajeroServicio::orderBy('id', 'desc')->get();
        return Inertia::render('PasajeroServicio/Index', compact('pasajeroservicios'));
        //return response()->json( ['pasajeroservicio' => $pasajeroservicio]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedPasajero = Pasajero::getFormattedForDropdown();
        $formattedItinerarioServicio = ItinerarioServicio::getFormattedForDropdown();
        //dd($formattedItinerarioServicio);
        return Inertia::render('PasajeroServicio/Create', 
        [
            'ListaPasajero' => $formattedPasajero,
            'ListaItinerarioServicio' => $formattedItinerarioServicio,
        ]);
        //return Inertia::render('PasajeroServicio/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        PasajeroServicio::create($data);
        return to_route('pasajero_servicio');
    }

    /**
     * Display the specified resource.
     */
    public function show(PasajeroServicio $pasajeroServicio)
    {
        // return Inertia::render('PasajeroServicio/Show', compact('pasajeroservicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PasajeroServicio $pasajeroServicio)
    {
        $formattedPasajero = Pasajero::getFormattedForDropdown();
        $formattedItinerarioServicio = ItinerarioServicio::getFormattedForDropdown();
        return Inertia::render('PasajeroServicio/Edit', 
        [
            'ListaPasajero' => $formattedPasajero,
            'ListaItinerarioServicio' => $formattedItinerarioServicio,
            'pasajeroServicio' => $pasajeroServicio,
        ]);
        //return Inertia::render('PasajeroServicio/Edit', compact('pasajeroServicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PasajeroServicio $pasajeroServicio)
    {
        $data = $request->all();
        $valor1 = $data['cotizacion_id'];
        $valor2 = $data['nro_dia'];
        $valor3 = $data['nro_orden'];
        $nuevoValor = $data['observacion'];
        $otroValor = $data['estatus'];
        
        PasajeroServicio::where('cotizacion_id', $valor1)
        ->where('nro_dia', $valor2)
        ->where('nro_orden', $valor3)
        ->update([
            'observacion' => $nuevoValor,
            'estatus' => $otroValor,
        ]);
        // Devolver redirect con mensaje flash
        return redirect()->back()->with('message', 'Guardado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasajeroServicio $pasajeroServicio)
    {
        $pasajeroServicio->delete();
        return to_route('pasajero_servicio');
    }
}
