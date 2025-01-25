<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServicioDetalle\StoreRequest;
use App\Models\ProveedorCategoria;
use App\Models\Costo;
use App\Models\Destino;
use App\Models\DistribucionVenta;
use App\Models\ServicioDetalle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ServicioDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$serviciodetalle = ServicioDetalle::all();
        $serviciodetalles = ServicioDetalle::with(
            [
                'proveedor_categoria:id,nombre',
                'costo:id,nombre',
                'destino:id,nombre',
                'distribucion_venta:id,nombre',
            ])
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('ServicioDetalle/Index', compact('serviciodetalles'));
        //return response()->json( ['serviciodetalle' => $serviciodetalle]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedCostos = Costo::getFormattedForDropdown();
        $formattedDestinos = Destino::getFormattedForDropdown();
        $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        return Inertia::render('ServicioDetalle/Create', ['proveedorcategorias' => $formattedCategorias, 'categoriaCostos' => $formattedCostos, 'categoriaDestinos' => $formattedDestinos, 'categoriaDistribuciones' => $formattedDistribuciones]); //compact('proveedorcategorias' => $formattedCategorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ServicioDetalle::create($data);
        return to_route('serviciodetalle');
    }

    public function storemodal(StoreRequest $request)
    {
        $data = $request->all();
        ServicioDetalle::create($data);
        $dataResponse = ServicioDetalle::getFormattedForDropdown();
        //return response()->json(ServicioDetalle::orderBy('id', 'desc')->get());
        return response()->json($dataResponse);
        //return to_route('servicio_clase');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServicioDetalle $servicioDetalle)
    {
        // return Inertia::render('ServicioDetalle/Show', compact('serviciodetalle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicioDetalle $servicioDetalle)
    {
        $formattedCategorias = ProveedorCategoria::getFormattedForDropdown();
        $formattedCostos = Costo::getFormattedForDropdown();
        $formattedDestinos = Destino::getFormattedForDropdown();
        $formattedDistribuciones = DistribucionVenta::getFormattedForDropdown();
        return Inertia::render('ServicioDetalle/Edit', ['proveedorcategorias' => $formattedCategorias, 'servicioDetalle' => $servicioDetalle,'categoriaCostos' => $formattedCostos, 'categoriaDestinos' => $formattedDestinos, 'categoriaDistribuciones' => $formattedDistribuciones]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicioDetalle $servicioDetalle)
    {
        $data = $request->all();
        //DB::enableQueryLog(); // Habilita el registro de consultas
        $servicioDetalle->update($data);
        //dd(DB::getQueryLog());        
        // origen del problema en las rutas {serviciodetalle} {servicio_detalle}
        //Route::patch('/dashboard/serviciodetalle/{serviciodetalle}/update', [ServicioDetalleController::class, 'update'])->name('serviciodetalle.update');
        //Route::patch('/dashboard/serviciodetalle/{servicio_detalle}/update', [ServicioDetalleController::class, 'update'])->name('serviciodetalle.update');
        return to_route('serviciodetalle');
        //return Inertia::render('ServicioDetalle/Edit', compact('servicioDetalle'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicioDetalle $servicioDetalle)
    {
        $servicioDetalle->delete();
        return to_route('serviciodetalle');
    }
}
