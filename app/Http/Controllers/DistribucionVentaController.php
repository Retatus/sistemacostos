<?php

namespace App\Http\Controllers;
use App\Http\Requests\DistribucionVenta\StoreRequest;
use App\Models\DistribucionVenta;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DistribucionVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$distribucionventa = DistribucionVenta::all();
        $distribucionventas = DistribucionVenta::orderBy('id', 'desc')->get();
        return Inertia::render('DistribucionVenta/Index', compact('distribucionventas'));
        //return response()->json( ['distribucionventa' => $distribucionventa]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('DistribucionVenta/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        DistribucionVenta::create($data);
        return to_route('distribucion_venta');
    }

    /**
     * Display the specified resource.
     */
    public function show(DistribucionVenta $distribucionVenta)
    {
        // return Inertia::render('DistribucionVenta/Show', compact('distribucionventa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistribucionVenta $distribucionVenta)
    {
        return Inertia::render('DistribucionVenta/Edit', compact('distribucionVenta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DistribucionVenta $distribucionVenta)
    {
        $data = $request->all();
        $distribucionVenta->update($data);
        return Inertia::render('DistribucionVenta/Edit', compact('distribucionVenta'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistribucionVenta $distribucionVenta)
    {
        $distribucionVenta->delete();
        return to_route('distribucion_venta');
    }
}
