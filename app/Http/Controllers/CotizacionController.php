<?php

namespace App\Http\Controllers;
use App\Http\Requests\Cotizacion\StoreRequest;
use App\Models\Cotizacion;
use App\Models\Destino;
use App\Models\DestinoTuristico;
use App\Models\Pais;
use App\Models\ServicioClase;
use App\Models\TipoComprobante;
use App\Models\TipoDocumento;
use App\Models\TipoPasajero;
use App\Models\TipoSunat;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cotizacion = Cotizacion::all();
        $formattedTipodocumento = TipoDocumento::getFormattedForDropdown();
        $formattedTipoSunat = TipoSunat::getFormattedForDropdown();
        $cotizacions = Cotizacion::orderBy('id', 'desc')->get();
        //return Inertia::render('Cotizacion/Index', compact('cotizacions'));
        return Inertia::render('Cotizacion/Index', 
        [
            'cotizacions' => $cotizacions, 
            'ListaTipoDocumento' => $formattedTipodocumento,
            //'ListaTipoComprobante' => $formattedTipodocomprobante,
            'ListaTipoSunat' => $formattedTipoSunat
        ]);
        //return response()->json( ['cotizacion' => $cotizacion]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedTipoComprobante = TipoComprobante::getFormattedForDropdown();
        $formattedDestinosTuristicos = DestinoTuristico::getFormattedForDropdown();
        $formattedPaises = Pais::getFormattedForDropdown();
        $formattedTipodocumento = TipoDocumento::getFormattedForDropdown();
        $formattedTipoPasajero = TipoPasajero::getFormattedForDropdown();
        $formattedTipoClase = ServicioClase::getFormattedForDropdown();
        $correlatico = Cotizacion::generarCorrelativo();
        return Inertia::render('Cotizacion/CreateCotizacion', 
        [
            'Correlativo' => $correlatico,
            'ListaTipoComprobante' => $formattedTipoComprobante,
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos,
            'ListaPaises' => $formattedPaises,
            'ListaTipoDocumento' => $formattedTipodocumento,
            'ListaTipoPasajero' => $formattedTipoPasajero,
            'ListaTipoClase' => $formattedTipoClase
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        Cotizacion::create($data);
        return to_route('cotizacion');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cotizacion $cotizacion)
    {
        // return Inertia::render('Cotizacion/Show', compact('cotizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotizacion $cotizacion)
    {
        return Inertia::render('Cotizacion/Edit', compact('cotizacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        $data = $request->all();
        $cotizacion->update($data);
        return Inertia::render('Cotizacion/Edit', compact('cotizacion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return to_route('cotizacion');
    }
}
