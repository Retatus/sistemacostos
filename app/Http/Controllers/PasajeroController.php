<?php

namespace App\Http\Controllers;
use App\Http\Requests\Pasajero\StoreRequest;
use App\Models\Cotizacion;
use App\Models\Pasajero;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
class PasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$pasajero = Pasajero::all();
        //$pasajeros = Pasajero::orderBy('id', 'desc')->get();
        $pasajeros = Pasajero::with([
            'cotizacion:id,file_nro',
            'tipo_docuemento:id,nombre',
            'pais:id,nombre',
            'tipo_pasajero:id,nombre',
            'tipo_clase:id,nombre',
            'cotizacion:id,file_nro',
        ])
        ->where('estado_activo', 1)
        ->orderBy('id', 'desc')
        ->paginate(10);
        return Inertia::render('Pasajero/Index', ['pasajeros' => $pasajeros]); //compact('pasajeros'));
        //return response()->json( ['pasajero' => $pasajero]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedCotizaciones = Cotizacion::getFormattedForDropdown();
        return Inertia::render('Pasajero/Create', 
        [
            'ListaCotizaciones' => $formattedCotizaciones
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('documento_file');
        if ($request->hasFile('documento_file')) {
            $file = $request->file('documento_file');
            $rutename = $file->store('documento_pasajero', ['disk' => 'public']);
            $data['documento_file'] = $rutename;
        }
        //dd($data);
        Pasajero::create($data);
        return to_route('pasajero');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasajero $pasajero)
    {
        // return Inertia::render('Pasajero/Show', compact('pasajero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasajero $pasajero)
    {
        $formattedCotizaciones = Cotizacion::getFormattedForDropdown();
        return Inertia::render('Pasajero/Edit', 
        [
            'ListaCotizaciones' => $formattedCotizaciones,
            'pasajero' => $pasajero      
        ]);
        //return Inertia::render('Pasajero/Edit', compact('pasajero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasajero $pasajero)
    {
        $data = $request->all();

        $request->except('documento_file'); // Exceptua algun campo antes de ser insertado en la base de datos 

        if ($request->hasFile('documento_file'));{
            $file = $request->file('documento_file');
            $rutename = $file->store('documento_pasajero', ['disk' => 'public']);
            $data['documento_file'] = $rutename;

            if($pasajero->documento_file){
                Storage::disk('public')->delete($pasajero->documento_file);
            }
        }

        $pasajero->update($data);
        return Inertia::render('Pasajero/Edit', compact('pasajero'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasajero $pasajero)
    {
        if($pasajero->documento_file){
            Storage::disk('public')->delete($pasajero->documento_file);
         }
        $pasajero->delete();
        return to_route('pasajero');
    }
}
