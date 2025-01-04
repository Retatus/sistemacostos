<?php

use App\Http\Controllers\CategoriaProveedorController;
use App\Http\Controllers\ClaseServicioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/dashboard/categoria_proveedor', [CategoriaProveedorController::class, 'index'])->name('categoria_proveedor');
    Route::get('/dashboard/categoria_proveedor/create', [CategoriaProveedorController::class, 'create'])->name('categoria_proveedor.create');
    Route::post('/dashboard/categoria_proveedor', [CategoriaProveedorController::class, 'store'])->name('categoria_proveedor.store');
    Route::get('/dashboard/categoria_proveedor/{categoria_proveedor}/edit', [CategoriaProveedorController::class, 'edit'])->name('categoria_proveedor.edit');
    Route::patch('/dashboard/categoria_proveedor/{categoria_proveedor}/update', [CategoriaProveedorController::class, 'update'])->name('categoria_proveedor.update');
    Route::delete('/dashboard//categoria_proveedor/{categoria_proveedor}/destroy', [CategoriaProveedorController::class, 'destroy'])->name('categoria_proveedor.destroy');

    Route::get('/dashboard/clase_servicio', [ClaseServicioController::class, 'index'])->name('clase_servicio');
    Route::get('/dashboard/clase_servicio/create', [ClaseServicioController::class, 'create'])->name('clase_servicio.create');
    Route::post('/dashboard/clase_servicio', [ClaseServicioController::class, 'store'])->name('clase_servicio.store');
    Route::get('/dashboard/clase_servicio/{clase_servicio}/edit', [ClaseServicioController::class, 'edit'])->name('clase_servicio.edit');
    Route::put('/dashboard/clase_servicio/{clase_servicio}', [ClaseServicioController::class, 'update'])->name('clase_servicio.update');
    Route::patch('/dashboard/clase_servicio/{clase_servicio}/update', [ClaseServicioController::class, 'update'])->name('clase_servicio.update');
    Route::delete('/dashboard//clase_servicio/{clase_servicio}/destroy', [ClaseServicioController::class, 'destroy'])->name('clase_servicio.destroy');





});
