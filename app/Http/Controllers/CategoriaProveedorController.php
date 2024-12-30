<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categoria_proveedor\StoreRequest;
use App\Http\Requests\Categoria_proveedor\UpdateRequest;
use App\Models\Categoria_proveedor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$categoriaproveedors = CategoriaProveedor::all();
        $categoriaproveedors = Categoria_proveedor::orderBy('id', 'desc')->get();        
        //dd($categoriaproveedors);                     ==> muestra el objeto, en consola
        //Inertia::render('Categoria_proveedor/Index')  ==> indica la carpeta en la que contien la vista
        return Inertia::render('Categoria_proveedor/Index', compact('categoriaproveedors'));
        //return response()->json( ['categoriaproveedors' => $categoriaproveedors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Categoria_proveedor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        //dd($request->all()); muestra el objeto enviado en la vista
        $data = $request->all();
        /** 
            *Importante!!! ejemplo para subir imagenes, https://www.youtube.com/watch?v=esIlt5wREL8 
            *$request->except('avatar'); // Exceptua algun campo antes de ser insertado en la base de datos 
            *if ($request->hasFile('avatar'));{
            *    $file = $request->file('avatar');
            *    $rutename = $file->store('avatar', ['disk' => 'public']);
            *    $data['avatar'] = $rutename;
            *}
        */
        Categoria_proveedor::create($data);
        return to_route('categoria_proveedor');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria_proveedor $categoria_proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria_proveedor $categoria_proveedor)
    {
        //dd($categoria_proveedor);
        return Inertia::render('Categoria_proveedor/Edit', compact('categoria_proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Categoria_proveedor $categoria_proveedor)
    {
        //dd($categoria_proveedor, $request->all());
        $data = $request->all();
        /*  
            //Importante!!! ejemplo para actualizar imagenes, https://www.youtube.com/watch?v=esIlt5wREL8
            $request->except('avatar'); // Exceptua algun campo antes de ser insertado en la base de datos 
            if ($request->hasFile('avatar'));{
                $file = $request->file('avatar');
                $rutename = $file->store('avatar', ['disk' => 'public']);
                $data['avatar'] = $rutename;

                if($categoria_proveedor->avatar){
                    Storage::disk('public')->delete($categoria_proveedor->avatar);
                }
            }
        */
        $categoria_proveedor->update($data);
        //return to_route('categoria_proveedors');
        //return to_route('categoria_proveedor/Edit', compact('categoria_proveedor'));
        return Inertia::render('Categoria_proveedor/Edit', compact('categoria_proveedor'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria_proveedor $categoria_proveedor)
    {
        // dd($categoria_proveedor);
        /** 
         * //Importante!!! ejemplo para eliminar imagenes, https://www.youtube.com/watch?v=esIlt5wREL8
         * if($categoria_proveedor->avatar){
         *    Storage::disk('public')->delete($categoria_proveedor->avatar);
         * }
         */
        $categoria_proveedor->delete();
        //dd("que pasa");
        return to_route('categoria_proveedor');
    }
}
