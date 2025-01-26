<?php

use App\Http\Controllers\CategoriaProveedorController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\DistribucionVentaController;
use App\Http\Controllers\ServicioClaseController;
use App\Http\Controllers\ServicioDetalleController;
use App\Http\Controllers\ProveedorCategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProveedorServicioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TipoDocumentoController;
use Illuminate\Support\Facades\Route;

// No autenticadas
Route::get('/', [DashboardController::class, 'index']); 

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    // /Autenticadas
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/categoria_proveedor', [CategoriaProveedorController::class, 'index'])->name('categoria_proveedor');
    Route::get('/dashboard/categoria_proveedor/create', [CategoriaProveedorController::class, 'create'])->name('categoria_proveedor.create');
    Route::post('/dashboard/categoria_proveedor', [CategoriaProveedorController::class, 'store'])->name('categoria_proveedor.store');
    Route::get('/dashboard/categoria_proveedor/{categoria_proveedor}/edit', [CategoriaProveedorController::class, 'edit'])->name('categoria_proveedor.edit');
    Route::patch('/dashboard/categoria_proveedor/{categoria_proveedor}/update', [CategoriaProveedorController::class, 'update'])->name('categoria_proveedor.update');
    Route::delete('/dashboard//categoria_proveedor/{categoria_proveedor}/destroy', [CategoriaProveedorController::class, 'destroy'])->name('categoria_proveedor.destroy');

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
    Route::get('/dashboard/proveedor/createProveedor', [ProveedorController::class, 'createProveedor'])->name('proveedor.createProveedor');
    Route::post('/dashboard/proveedor/indexProveedor', [ProveedorController::class, 'indexProveedor'])->name('proveedor.indexProveedor');
    Route::post('/dashboard/proveedor', [ProveedorController::class, 'store'])->name('proveedor.store');
    Route::get('/dashboard/proveedor/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('proveedor.edit');
    Route::patch('/dashboard/proveedor/{proveedor}/update', [ProveedorController::class, 'update'])->name('proveedor.update');
    Route::delete('/dashboard/proveedor/{proveedor}/destroy', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');

    //Route::get('/api/proveedores', function (Request $request) { return Proveedor::paginate(10); });
    //Route::resource('/dashboard/servicio_clase', ServicioClaseController::class);
    Route::get('/dashboard/servicio_clase', [ServicioClaseController::class, 'index'])->name('servicio_clase');
    Route::get('/dashboard/servicio_clase/create', [ServicioClaseController::class, 'create'])->name('servicio_clase.create');
    Route::post('/dashboard/servicio_clase', [ServicioClaseController::class, 'store'])->name('servicio_clase.store');
    Route::post('/dashboard/servicio_clase/storemodal', [ServicioClaseController::class, 'storemodal'])->name('servicio_clase.storemodal');
    Route::get('/dashboard/servicio_clase/{servicio_clase}/edit', [ServicioClaseController::class, 'edit'])->name('servicio_clase.edit');
    Route::patch('/dashboard/servicio_clase/{servicio_clase}/update', [ServicioClaseController::class, 'update'])->name('servicio_clase.update');
    Route::delete('/dashboard/servicio_clase/{servicio_clase}/destroy', [ServicioClaseController::class, 'destroy'])->name('servicio_clase.destroy');

    Route::get('/dashboard/serviciodetalle', [ServicioDetalleController::class, 'index'])->name('serviciodetalle');
    Route::get('/dashboard/serviciodetalle/create', [ServicioDetalleController::class, 'create'])->name('serviciodetalle.create');
    Route::post('/dashboard/serviciodetalle', [ServicioDetalleController::class, 'store'])->name('serviciodetalle.store');
    Route::post('/dashboard/serviciodetalle/storemodal', [ServicioDetalleController::class, 'storemodal'])->name('serviciodetalle.storemodal');
    Route::post('/dashboard/serviciodetalle/serviceCategory', [ServicioDetalleController::class, 'serviceCategory'])->name('serviciodetalle.serviceCategory');
    Route::get('/dashboard/serviciodetalle/{servicio_detalle}/edit', [ServicioDetalleController::class, 'edit'])->name('serviciodetalle.edit');
    Route::patch('/dashboard/serviciodetalle/{servicio_detalle}/update', [ServicioDetalleController::class, 'update'])->name('serviciodetalle.update');
    Route::delete('/dashboard/serviciodetalle/{serviciodetalle}/destroy', [ServicioDetalleController::class, 'destroy'])->name('serviciodetalle.destroy');

    Route::get('/dashboard/costo', [CostoController::class, 'index'])->name('costo');
    Route::get('/dashboard/costo/create', [CostoController::class, 'create'])->name('costo.create');
    Route::post('/dashboard/costo', [CostoController::class, 'store'])->name('costo.store');
    Route::get('/dashboard/costo/{costo}/edit', [CostoController::class, 'edit'])->name('costo.edit');
    Route::patch('/dashboard/costo/{costo}/update', [CostoController::class, 'update'])->name('costo.update');
    Route::delete('/dashboard/costo/{costo}/destroy', [CostoController::class, 'destroy'])->name('costo.destroy');

    Route::get('/dashboard/destino', [DestinoController::class, 'index'])->name('destino');
    Route::get('/dashboard/destino/create', [DestinoController::class, 'create'])->name('destino.create');
    Route::post('/dashboard/destino', [DestinoController::class, 'store'])->name('destino.store');
    Route::get('/dashboard/destino/{destino}/edit', [DestinoController::class, 'edit'])->name('destino.edit');
    Route::patch('/dashboard/destino/{destino}/update', [DestinoController::class, 'update'])->name('destino.update');
    Route::delete('/dashboard/destino/{destino}/destroy', [DestinoController::class, 'destroy'])->name('destino.destroy');

    Route::get('/dashboard/distribucion_venta', [DistribucionVentaController::class, 'index'])->name('distribucion_venta');
    Route::get('/dashboard/distribucion_venta/create', [DistribucionVentaController::class, 'create'])->name('distribucion_venta.create');
    Route::post('/dashboard/distribucion_venta', [DistribucionVentaController::class, 'store'])->name('distribucion_venta.store');
    Route::get('/dashboard/distribucion_venta/{distribucion_venta}/edit', [DistribucionVentaController::class, 'edit'])->name('distribucion_venta.edit');
    Route::patch('/dashboard/distribucion_venta/{distribucion_venta}/update', [DistribucionVentaController::class, 'update'])->name('distribucion_venta.update');
    Route::delete('/dashboard/distribucion_venta/{distribucion_venta}/destroy', [DistribucionVentaController::class, 'destroy'])->name('distribucion_venta.destroy');

    Route::get('/dashboard/servicio', [ServicioController::class, 'index'])->name('servicio');
    Route::get('/dashboard/servicio/create', [ServicioController::class, 'create'])->name('servicio.create');
    Route::post('/dashboard/servicio', [ServicioController::class, 'store'])->name('servicio.store');
    Route::get('/dashboard/servicio/{servicio}/edit', [ServicioController::class, 'edit'])->name('servicio.edit');
    Route::patch('/dashboard/servicio/{servicio}/update', [ServicioController::class, 'update'])->name('servicio.update');
    Route::delete('/dashboard/servicio/{servicio}/destroy', [ServicioController::class, 'destroy'])->name('servicio.destroy');

    Route::get('/dashboard/proveedor_servicio', [ProveedorServicioController::class, 'index'])->name('proveedor_servicio');
    Route::get('/dashboard/proveedor_servicio/create', [ProveedorServicioController::class, 'create'])->name('proveedor_servicio.create');
    Route::post('/dashboard/proveedor_servicio', [ProveedorServicioController::class, 'store'])->name('proveedor_servicio.store');
    Route::get('/dashboard/proveedor_servicio/{proveedor_servicio}/edit', [ProveedorServicioController::class, 'edit'])->name('proveedor_servicio.edit');
    Route::patch('/dashboard/proveedor_servicio/{proveedor_servicio}/update', [ProveedorServicioController::class, 'update'])->name('proveedor_servicio.update');
    Route::delete('/dashboard/proveedor_servicio/{proveedor_servicio}/destroy', [ProveedorServicioController::class, 'destroy'])->name('proveedor_servicio.destroy');

});
