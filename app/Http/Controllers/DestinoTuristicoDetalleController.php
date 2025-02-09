<?php

namespace App\Http\Controllers;
use App\Http\Requests\DestinoTuristicoDetalle\StoreRequest;
use App\Models\DestinoTuristico;
use App\Models\DestinoTuristicoDetalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DestinoTuristicoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$destinoturisticodetalle = DestinoTuristicoDetalle::all();
        // $destinoturisticodetalles = DestinoTuristicoDetalle::orderBy('id', 'desc')->get();
        // return Inertia::render('DestinoTuristicoDetalle/Index', compact('destinoturisticodetalles'));
        //return response()->json( ['destinoturisticodetalle' => $destinoturisticodetalle]);

        // Obtener las categorías formateadas
        $formattedCategorias = DestinoTuristico::getFormattedForDropdown();

        // Parámetros de búsqueda
        $nombre = $request->input('nombre') ?? ''; 
        // Consulta principal
        $destinoturisticodetalles = DestinoTuristicoDetalle::with('destinoturistico:id,nombre')
            ->where('estado_activo', 1)
            ->when($nombre, function ($query, $nombre) {
                $query->where(function ($q) use ($nombre) {
                    $q->where('nombre', 'LIKE', "%{$nombre}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Verificar si es una solicitud AJAX o normal
        if ($request->wantsJson()) {
            // Respuesta para solicitudes AJAX (búsquedas)
            return response()->json(['destinoturisticodetalles' => $destinoturisticodetalles, 'ListaDestinoTuristico' => $formattedCategorias, ]);
        }

        // Respuesta para cargar la vista inicial
        return Inertia::render('DestinoTuristicoDetalle/Index', ['destinoturisticodetalles' => $destinoturisticodetalles, 'ListaDestinoTuristico' => $formattedCategorias, ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedCategorias = DestinoTuristico::getFormattedForDropdown();
        return Inertia::render('DestinoTuristicoDetalle/Create', 
        [
            'destinoturisticoslista' => $formattedCategorias,
        ]); //compact('proveedorcategorias'));
        //return Inertia::render('DestinoTuristicoDetalle/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        DestinoTuristicoDetalle::create($data);
        return to_route('destino_turistico_detalle');
    }

    /**
     * Display the specified resource.
     */
    public function show(DestinoTuristicoDetalle $destinoTuristicoDetalle)
    {
        // return Inertia::render('DestinoTuristicoDetalle/Show', compact('destinoturisticodetalle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinoTuristicoDetalle $destinoTuristicoDetalle)
    {
        $formattedCategorias = DestinoTuristico::getFormattedForDropdown();
        return Inertia::render('DestinoTuristicoDetalle/Edit', 
        [
            'destinoTuristicoDetalle' => $destinoTuristicoDetalle, 
            'destinoturisticoslista' => $formattedCategorias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestinoTuristicoDetalle $destinoTuristicoDetalle)
    {
        $data = $request->all();
        $destinoTuristicoDetalle->update($data);
        return Inertia::render('DestinoTuristicoDetalle/Edit', compact('destinoTuristicoDetalle'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinoTuristicoDetalle $destinoTuristicoDetalle)
    {
        $destinoTuristicoDetalle->delete();
        return to_route('destino_turistico_detalle');
    }
}
