<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProveedorCategoria\StoreRequest;
use App\Models\ProveedorCategoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProveedorCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$proveedorcategoria = ProveedorCategoria::all();
        $proveedorcategorias = ProveedorCategoria::orderBy('id', 'desc')->get();
        return Inertia::render('ProveedorCategoria/Index', compact('proveedorcategorias'));
        //return response()->json( ['proveedorcategoria' => $proveedorcategoria]);
    }

    public function selectOptions()
    {
        $categories = ProveedorCategoria::getFormattedForDropdown();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ProveedorCategoria/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        ProveedorCategoria::create($data);
        return to_route('proveedor_categoria');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProveedorCategoria $proveedorCategoria)
    {
        // return Inertia::render('ProveedorCategoria/Show', compact('proveedorcategoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProveedorCategoria $proveedorCategoria)
    {
        return Inertia::render('ProveedorCategoria/Edit', compact('proveedorCategoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, ProveedorCategoria $proveedorCategoria)
    {
        $data = $request->all();
        $proveedorCategoria->update($data);
        return Inertia::render('ProveedorCategoria/Edit', compact('proveedorCategoria'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProveedorCategoria $proveedorCategoria)
    {
        $proveedorCategoria->delete();
        return to_route('proveedor_categoria');
    }
}
