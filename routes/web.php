<?php

use App\Http\Controllers\CategoriaProveedorController;
use App\Http\Controllers\ClaseServicioController;
use App\Http\Controllers\ServicioClaseController;
use App\Http\Controllers\ServicioDetalleController;
use App\Http\Controllers\ProveedorCategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TipoDocumentoController;
use App\Models\proveedor;
use App\Models\ServicioClase;
use App\Models\ServicioDetalle;
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
    Route::delete('/dashboard/clase_servicio/{clase_servicio}/destroy', [ClaseServicioController::class, 'destroy'])->name('clase_servicio.destroy');

    // Forma simplificada de las rutas 
    // Comando para listar las Rutas, ---->> php artisan r:l
    // Route::resource('/dashboard/tipo_documento', TipoDocumentoController::class);
    Route::get('/dashboard/tipo_documento/crear', [TipoDocumentoController::class, 'crear'])->name('tipo_documento.crear');

    Route::get('/dashboard/tipo_documento', [TipoDocumentoController::class, 'index'])->name('tipo_documento');
    Route::get('/dashboard/tipo_documento/create', [TipoDocumentoController::class, 'create'])->name('tipo_documento.create');
    Route::post('/dashboard/tipo_documento', [TipoDocumentoController::class, 'store'])->name('tipo_documento.store');
    Route::get('/dashboard/tipo_documento/{tipo_documento}/edit', [TipoDocumentoController::class, 'edit'])->name('tipo_documento.edit');
    Route::patch('/dashboard/tipo_documento/{tipo_documento}/update', [TipoDocumentoController::class, 'update'])->name('tipo_documento.update');
    Route::delete('/dashboard//tipo_documento/{tipo_documento}/destroy', [TipoDocumentoController::class, 'destroy'])->name('tipo_documento.destroy');
    //Route::get('/categoria/crear', [CategoriaController::class, 'crear'])->name('categoria.crear');

    Route::get('/dashboard/proveedor_categoria', [ProveedorCategoriaController::class, 'index'])->name('proveedor_categoria');
    Route::get('/dashboard/proveedor_categoria/create', [ProveedorCategoriaController::class, 'create'])->name('proveedor_categoria.create');
    Route::post('/dashboard/proveedor_categoria', [ProveedorCategoriaController::class, 'store'])->name('proveedor_categoria.store');
    Route::get('/dashboard/proveedor_categoria/{proveedor_categoria}/edit', [ProveedorCategoriaController::class, 'edit'])->name('proveedor_categoria.edit');
    Route::patch('/dashboard/proveedor_categoria/{proveedor_categoria}/update', [ProveedorCategoriaController::class, 'update'])->name('proveedor_categoria.update');
    Route::delete('/dashboard/proveedor_categoria/{proveedor_categoria}/destroy', [ProveedorCategoriaController::class, 'destroy'])->name('proveedor_categoria.destroy');

    Route::get('/dashboard/proveedor', [ProveedorController::class, 'index'])->name('proveedor');
    Route::get('/dashboard/proveedor/create', [ProveedorController::class, 'create'])->name('proveedor.create');
    Route::post('/dashboard/proveedor', [ProveedorController::class, 'store'])->name('proveedor.store');
    Route::get('/dashboard/proveedor/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('proveedor.edit');
    Route::patch('/dashboard/proveedor/{proveedor}/update', [ProveedorController::class, 'update'])->name('proveedor.update');
    Route::delete('/dashboard/proveedor/{proveedor}/destroy', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');

    Route::get('/dashboard/servicio_clase', [ServicioClaseController::class, 'index'])->name('servicio_clase');
    Route::get('/dashboard/servicio_clase/create', [ServicioClaseController::class, 'create'])->name('servicio_clase.create');
    Route::post('/dashboard/servicio_clase', [ServicioClaseController::class, 'store'])->name('servicio_clase.store');
    Route::post('/dashboard/servicio_clase', [ServicioClaseController::class, 'storemodal'])->name('servicio_clase.storemodal');
    Route::get('/dashboard/servicio_clase/{servicio_clase}/edit', [ServicioClaseController::class, 'edit'])->name('servicio_clase.edit');
    Route::patch('/dashboard/servicio_clase/{servicio_clase}/update', [ServicioClaseController::class, 'update'])->name('servicio_clase.update');
    Route::delete('/dashboard/servicio_clase/{servicio_clase}/destroy', [ServicioClaseController::class, 'destroy'])->name('servicio_clase.destroy');

    Route::get('/dashboard/servicio_detalle', [ServicioDetalleController::class, 'index'])->name('servicio_detalle');
    Route::get('/dashboard/servicio_detalle/create', [ServicioDetalleController::class, 'create'])->name('servicio_detalle.create');
    Route::post('/dashboard/servicio_detalle', [ServicioDetalleController::class, 'store'])->name('servicio_detalle.store');
    Route::get('/dashboard/servicio_detalle/{servicio_detalle}/edit', [ServicioDetalleController::class, 'edit'])->name('servicio_detalle.edit');
    Route::patch('/dashboard/servicio_detalle/{servicio_detalle}/update', [ServicioDetalleController::class, 'update'])->name('servicio_detalle.update');
    Route::delete('/dashboard/servicio_detalle/{servicio_detalle}/destroy', [ServicioDetalleController::class, 'destroy'])->name('servicio_detalle.destroy');

});
