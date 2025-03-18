<?php

namespace App\Http\Controllers;
use App\Http\Requests\Cotizacion\StoreRequest;
use App\Http\Requests\Cotizacion\UpdateRequest;
use App\Http\Requests\Cotizacion\CotizacionRequest;
use App\Models\Cotizacion;
use App\Models\Destino;
use App\Models\DestinoTuristico;
use App\Models\Pais;
use App\Models\Pasajero;
use App\Models\PasajeroServicio;
use App\Models\ProveedorCategoria;
use App\Models\ServicioClase;
use App\Models\TipoComprobante;
use App\Models\TipoDocumento;
use App\Models\TipoPasajero;
use App\Models\TipoSunat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cotizacion = Cotizacion::all();
        //$cotizacions = Cotizacion::orderBy('id', 'desc')->get();
        $cotizacions = Cotizacion::with([
            'tipo_comprobante:id,nombre',
            'pais:id,nombre',
            'idioma:id,nombre',
            'mercado:id,nombre',
        ])
        ->where('estado_activo', 1)
        ->orderBy('id', 'desc')
        ->paginate(10);

        return Inertia::render('Cotizacion/Index', ['cotizacions' => $cotizacions]);
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
        $formattedProveedorCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedTipoSunat = TipoSunat::getFormattedForDropdown();
        return Inertia::render('Cotizacion/CreateCotizacion', 
        [
            'Correlativo' => $correlatico,
            'ListaTipoComprobante' => $formattedTipoComprobante,
            'ListaDestinosTuristicos' => $formattedDestinosTuristicos,
            'ListaPaises' => $formattedPaises,
            'ListaTipoDocumento' => $formattedTipodocumento,
            'ListaTipoPasajero' => $formattedTipoPasajero,
            'ListaTipoClase' => $formattedTipoClase,
            'ListaProveedorCategorias' => $formattedProveedorCategorias,
            'ListaTipoSunat' => $formattedTipoSunat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $dataCotizacion = $request->except(['Pasajeros','PasajeroServicio']);
            $dataCotizacion['file_nro'] = Cotizacion::generarCorrelativo();
            $cotizacionResponse = Cotizacion::create($dataCotizacion);

            $pasajero_servicios = $data['PasajeroServicio'] ?? [];

            foreach ($pasajero_servicios as $pasajero_servicio) {                   // PasajeroServicio

                $detalle = $pasajero_servicio['detalle'] ?? [];

                foreach ($detalle as $servicio) {                                   // Detalle

                    $pasajero = $servicio['pasajero'] ?? [];
                    $pasajero['cotizacion_id'] = $cotizacionResponse->id;

                    // Verificar si existe un archivo 'documento_file' en el array $pasajero
                    if (isset($pasajero['documento_file']) && $pasajero['documento_file'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $pasajero['documento_file'];
                        $rutename = $file->store('documento_pasajero', ['disk' => 'public']);
                        $pasajero['documento_file'] = $rutename; // Guardar la ruta del archivo en el array
                    }

                    $pasajeroResponse = Pasajero::create($pasajero);

                    $pasajero_servicio_detalle = $servicio['servicio_detalle'] ?? [];

                    foreach ($pasajero_servicio_detalle as $servicio_detalle) {     // ServicioDetalle
                        $pasajerocotizacion['pasajero_id'] = $pasajeroResponse->id;
                        $pasajerocotizacion['itinerario_servicio_id'] = $servicio_detalle['id'];
                                          
                        $pasajero_servicio_response = PasajeroServicio::create($pasajerocotizacion);
                    }
                }
            }
        });
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
