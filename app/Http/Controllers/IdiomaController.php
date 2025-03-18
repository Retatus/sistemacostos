<?php

namespace App\Http\Controllers;
use App\Http\Requests\Idioma\StoreRequest;
use App\Models\Idioma;
use Illuminate\Http\Request;
use Inertia\Inertia;
class IdiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$idioma = Idioma::all();
        $idiomas = Idioma::orderBy('id', 'desc')->get();
        return Inertia::render('Idioma/Index', compact('idiomas'));
        //return response()->json( ['idioma' => $idioma]);
    }

    public function selectOptions()
    {
        $categories = Idioma::getFormattedForDropdown();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Idioma/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Idioma::create($data);
        return to_route('idioma');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idioma $idioma)
    {
        // return Inertia::render('Idioma/Show', compact('idioma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idioma $idioma)
    {
        return Inertia::render('Idioma/Edit', compact('idioma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Idioma $idioma)
    {
        $data = $request->all();
        $idioma->update($data);
        return Inertia::render('Idioma/Edit', compact('idioma'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idioma $idioma)
    {
        $idioma->delete();
        return to_route('idioma');
    }
}
