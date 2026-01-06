<?php

use App\Http\Controllers\CategoriaProveedorController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\DestinoTuristicoController;
use App\Http\Controllers\DestinoTuristicoDetalleController;
use App\Http\Controllers\DistribucionVentaController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\ItinerarioController;
use App\Http\Controllers\ItinerarioDestinoController;
use App\Http\Controllers\ItinerarioServicioController;
use App\Http\Controllers\MercadoController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\PasajeroController;
use App\Http\Controllers\PasajeroServicioController;
use App\Http\Controllers\PrecioController;
use App\Http\Controllers\ServicioClaseController;
use App\Http\Controllers\ServicioDetalleController;
use App\Http\Controllers\ProveedorCategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProveedorServicioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TipoComprobanteController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\TipoPasajeroController;
use App\Http\Controllers\TipoSunatController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\TipoHabitacionController;
use App\Models\ItinerarioDestino;
use App\Models\PasajeroServicio;
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
    Route::get('/dashboard/tipo_documento/selectOptions', [TipoDocumentoController::class, 'selectOptions'])->name('tipo_documento.selectOptions'); 
    Route::get('/dashboard/tipo_documento/create', [TipoDocumentoController::class, 'create'])->name('tipo_documento.create');
    Route::post('/dashboard/tipo_documento', [TipoDocumentoController::class, 'store'])->name('tipo_documento.store');
    Route::get('/dashboard/tipo_documento/{tipo_documento}/edit', [TipoDocumentoController::class, 'edit'])->name('tipo_documento.edit');
    Route::patch('/dashboard/tipo_documento/{tipo_documento}/update', [TipoDocumentoController::class, 'update'])->name('tipo_documento.update');
    Route::delete('/dashboard//tipo_documento/{tipo_documento}/destroy', [TipoDocumentoController::class, 'destroy'])->name('tipo_documento.destroy');
    //Route::get('/categoria/crear', [CategoriaController::class, 'crear'])->name('categoria.crear');

    Route::get('/dashboard/tipo_comprobante', [TipoComprobanteController::class, 'index'])->name('tipo_comprobante');
    Route::get('/dashboard/tipo_comprobante/selectOptions', [TipoComprobanteController::class, 'selectOptions'])->name('tipo_comprobante.selectOptions'); 
    Route::get('/dashboard/tipo_comprobante/create', [TipoComprobanteController::class, 'create'])->name('tipo_comprobante.create');
    Route::post('/dashboard/tipo_comprobante', [TipoComprobanteController::class, 'store'])->name('tipo_comprobante.store');
    Route::get('/dashboard/tipo_comprobante/{tipo_comprobante}/edit', [TipoComprobanteController::class, 'edit'])->name('tipo_comprobante.edit');
    Route::patch('/dashboard/tipo_comprobante/{tipo_comprobante}/update', [TipoComprobanteController::class, 'update'])->name('tipo_comprobante.update');
    Route::delete('/dashboard//tipo_comprobante/{tipo_comprobante}/destroy', [TipoComprobanteController::class, 'destroy'])->name('tipo_comprobante.destroy');

    Route::get('/dashboard/tipo_sunat', [TipoSunatController::class, 'index'])->name('tipo_sunat');
    Route::get('/dashboard/tipo_sunat/selectOptions', [TipoSunatController::class, 'selectOptions'])->name('tipo_sunat.selectOptions'); 
    Route::get('/dashboard/tipo_sunat/create', [TipoSunatController::class, 'create'])->name('tipo_sunat.create');
    Route::post('/dashboard/tipo_sunat', [TipoSunatController::class, 'store'])->name('tipo_sunat.store');
    Route::get('/dashboard/tipo_sunat/{tipo_sunat}/edit', [TipoSunatController::class, 'edit'])->name('tipo_sunat.edit');
    Route::patch('/dashboard/tipo_sunat/{tipo_sunat}/update', [TipoSunatController::class, 'update'])->name('tipo_sunat.update');
    Route::delete('/dashboard//tipo_sunat/{tipo_sunat}/destroy', [TipoSunatController::class, 'destroy'])->name('tipo_sunat.destroy');

    Route::get('/dashboard/proveedor_categoria', [ProveedorCategoriaController::class, 'index'])->name('proveedor_categoria');
    Route::get('/dashboard/proveedor_categoria/selectOptions', [ProveedorCategoriaController::class, 'selectOptions'])->name('proveedor_categoria.selectOptions');    
    Route::get('/dashboard/proveedor_categoria/create', [ProveedorCategoriaController::class, 'create'])->name('proveedor_categoria.create');
    Route::post('/dashboard/proveedor_categoria', [ProveedorCategoriaController::class, 'store'])->name('proveedor_categoria.store');
    Route::get('/dashboard/proveedor_categoria/{proveedor_categoria}/edit', [ProveedorCategoriaController::class, 'edit'])->name('proveedor_categoria.edit');
    Route::patch('/dashboard/proveedor_categoria/{proveedor_categoria}/update', [ProveedorCategoriaController::class, 'update'])->name('proveedor_categoria.update');
    Route::delete('/dashboard/proveedor_categoria/{proveedor_categoria}/destroy', [ProveedorCategoriaController::class, 'destroy'])->name('proveedor_categoria.destroy');

    Route::get('/dashboard/proveedor', [ProveedorController::class, 'index'])->name('proveedor');
    Route::get('/dashboard/proveedor/create', [ProveedorController::class, 'create'])->name('proveedor.create');
    Route::post('/dashboard/proveedor/find', [ProveedorController::class, 'find'])->name('proveedor.find');
    Route::get('/dashboard/proveedor/createProveedor', [ProveedorController::class, 'createProveedor'])->name('proveedor.createProveedor');
    Route::post('/dashboard/proveedor/indexProveedor', [ProveedorController::class, 'indexProveedor'])->name('proveedor.indexProveedor');
    Route::post('/dashboard/proveedor', [ProveedorController::class, 'store'])->name('proveedor.store');
    
    Route::post('/dashboard/proveedor/proveedorList', [ProveedorController::class, 'proveedorList'])->name('proveedor.proveedorList');
    Route::get('/dashboard/proveedor/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('proveedor.edit');
    Route::patch('/dashboard/proveedor/{proveedor}/update', [ProveedorController::class, 'update'])->name('proveedor.update');
    Route::delete('/dashboard/proveedor/{proveedor}/destroy', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');
    Route::get('/dashboard/proveedor/proveedorAlojamiento', [ProveedorController::class, 'proveedorAlojamiento'])->name('proveedor.proveedorAlojamiento');
    Route::get('/dashboard/proveedor/{proveedor}/proveedorHabitacion', [ProveedorController::class, 'proveedorHabitacion'])->name('proveedor.proveedorHabitacion');

    // Route::prefix('/dashboard/proveedor')->group(function () {
    //     // 1️⃣ Proveedores sugeridos para alojamiento
    //     Route::get('/', [ProveedorController::class, 'proveedoresAlojamiento']);
    //     // GET /api/proveedor?destino=1&pasajeros=4

    //     // 2️⃣ Habitaciones de un proveedor
    //     Route::get('{proveedor}/habitaciones', [ProveedorController::class, 'habitacionesProveedor']);
    //     // GET /api/proveedor/5/habitaciones
    // });

    //Route::get('/api/proveedores', function (Request $request) { return Proveedor::paginate(10); });
    //Route::resource('/dashboard/servicio_clase', ServicioClaseController::class);

    Route::get('/dashboard/servicio_clase', [ServicioClaseController::class, 'index'])->name('servicio_clase');
    Route::get('/dashboard/servicio_clase/selectOptions', [ServicioClaseController::class, 'selectOptions'])->name('servicio_clase.selectOptions'); 
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
    Route::post('/dashboard/servicio/servicioList', [ServicioController::class, 'servicioList'])->name('servicio.servicioList');
    Route::get('/dashboard/servicio/{servicio}/edit', [ServicioController::class, 'edit'])->name('servicio.edit');
    Route::patch('/dashboard/servicio/{servicio}/update', [ServicioController::class, 'update'])->name('servicio.update');
    Route::delete('/dashboard/servicio/{servicio}/destroy', [ServicioController::class, 'destroy'])->name('servicio.destroy');

    Route::get('/dashboard/proveedor_servicio', [ProveedorServicioController::class, 'index'])->name('proveedor_servicio');
    Route::get('/dashboard/proveedor_servicio/create', [ProveedorServicioController::class, 'create'])->name('proveedor_servicio.create');
    Route::post('/dashboard/proveedor_servicio', [ProveedorServicioController::class, 'store'])->name('proveedor_servicio.store');
    Route::get('/dashboard/proveedor_servicio/{proveedor_servicio}/edit', [ProveedorServicioController::class, 'edit'])->name('proveedor_servicio.edit');
    Route::patch('/dashboard/proveedor_servicio/{proveedor_servicio}/update', [ProveedorServicioController::class, 'update'])->name('proveedor_servicio.update');
    Route::delete('/dashboard/proveedor_servicio/{proveedor_servicio}/destroy', [ProveedorServicioController::class, 'destroy'])->name('proveedor_servicio.destroy');

    Route::get('/dashboard/destino_turistico', [DestinoTuristicoController::class, 'index'])->name('destino_turistico');
    Route::get('/dashboard/destino_turistico/create', [DestinoTuristicoController::class, 'create'])->name('destino_turistico.create');
    Route::post('/dashboard/destino_turistico', [DestinoTuristicoController::class, 'store'])->name('destino_turistico.store');
    Route::post('/dashboard/destino_turistico/destinoServicios', [DestinoTuristicoController::class, 'destinoServicios'])->name('destino_turistico.destinoServicios');    
    Route::get('/dashboard/destino_turistico/{destino_turistico}/edit', [DestinoTuristicoController::class, 'edit'])->name('destino_turistico.edit');
    Route::patch('/dashboard/destino_turistico/{destino_turistico}/update', [DestinoTuristicoController::class, 'update'])->name('destino_turistico.update');
    Route::delete('/dashboard/destino_turistico/{destino_turistico}/destroy', [DestinoTuristicoController::class, 'destroy'])->name('destino_turistico.destroy');

    // Route::get('/dashboard/destino_turistico_detalle', [DestinoTuristicoDetalleController::class, 'index'])->name('destino_turistico_detalle');
    // Route::get('/dashboard/destino_turistico_detalle/create', [DestinoTuristicoDetalleController::class, 'create'])->name('destino_turistico_detalle.create');
    // Route::post('/dashboard/destino_turistico_detalle', [DestinoTuristicoDetalleController::class, 'store'])->name('destino_turistico_detalle.store');
    // Route::get('/dashboard/destino_turistico_detalle/{destino_turistico_detalle}/edit', [DestinoTuristicoDetalleController::class, 'edit'])->name('destino_turistico_detalle.edit');
    // Route::patch('/dashboard/destino_turistico_detalle/{destino_turistico_detalle}/update', [DestinoTuristicoDetalleController::class, 'update'])->name('destino_turistico_detalle.update');
    // Route::delete('/dashboard/destino_turistico_detalle/{destino_turistico_detalle}/destroy', [DestinoTuristicoDetalleController::class, 'destroy'])->name('destino_turistico_detalle.destroy');

    //Route::resource('/dashboard/pais', PaisController::class);
    Route::get('/dashboard/pais', [PaisController::class, 'index'])->name('pais');
    Route::get('/dashboard/pais/selectOptions', [PaisController::class, 'selectOptions'])->name('pais.selectOptions'); 
    Route::get('/dashboard/pais/create', [PaisController::class, 'create'])->name('pais.create');
    Route::post('/dashboard/pais', [PaisController::class, 'store'])->name('pais.store');
    Route::get('/dashboard/pais/{pais}/edit', [PaisController::class, 'edit'])->name('pais.edit');
    Route::patch('/dashboard/pais/{pais}/update', [PaisController::class, 'update'])->name('pais.update');
    Route::delete('/dashboard/pais/{pais}/destroy', [PaisController::class, 'destroy'])->name('pais.destroy');

    //Route::resource('/dashboard/ubicacions', UbicacionController::class);
    Route::get('/dashboard/ubicacion', [UbicacionController::class, 'index'])->name('ubicacion');
    Route::get('/dashboard/ubicacion/selectOptions', [UbicacionController::class, 'selectOptions'])->name('ubicacion.selectOptions'); 
    Route::get('/dashboard/ubicacion/create', [UbicacionController::class, 'create'])->name('ubicacion.create');
    Route::post('/dashboard/ubicacion', [UbicacionController::class, 'store'])->name('ubicacion.store');
    Route::get('/dashboard/ubicacion/{ubicacion}/edit', [UbicacionController::class, 'edit'])->name('ubicacion.edit');
    Route::patch('/dashboard/ubicacion/{ubicacion}/update', [UbicacionController::class, 'update'])->name('ubicacion.update');
    Route::delete('/dashboard/ubicacion/{ubicacion}/destroy', [UbicacionController::class, 'destroy'])->name('ubicacion.destroy');

    Route::get('/dashboard/itinerario', [ItinerarioController::class, 'index'])->name('itinerario');
    Route::get('/dashboard/itinerario/create', [ItinerarioController::class, 'create'])->name('itinerario.create');
    Route::post('/dashboard/itinerario', [ItinerarioController::class, 'store'])->name('itinerario.store');
    Route::get('/dashboard/itinerario/{itinerario}/edit', [ItinerarioController::class, 'edit'])->name('itinerario.edit');
    Route::patch('/dashboard/itinerario/{itinerario}/update', [ItinerarioController::class, 'update'])->name('itinerario.update');
    Route::delete('/dashboard/itinerario/{itinerario}/destroy', [ItinerarioController::class, 'destroy'])->name('itinerario.destroy');

    Route::get('/dashboard/tipo_pasajero', [TipoPasajeroController::class, 'index'])->name('tipo_pasajero');
    Route::get('/dashboard/tipo_pasajero/selectOptions', [TipoPasajeroController::class, 'selectOptions'])->name('tipo_pasajero.selectOptions'); 
    Route::get('/dashboard/tipo_pasajero/create', [TipoPasajeroController::class, 'create'])->name('tipo_pasajero.create');
    Route::post('/dashboard/tipo_pasajero', [TipoPasajeroController::class, 'store'])->name('tipo_pasajero.store');
    Route::get('/dashboard/tipo_pasajero/{tipo_pasajero}/edit', [TipoPasajeroController::class, 'edit'])->name('tipo_pasajero.edit');
    Route::patch('/dashboard/tipo_pasajero/{tipo_pasajero}/update', [TipoPasajeroController::class, 'update'])->name('tipo_pasajero.update');
    Route::delete('/dashboard/tipo_pasajero/{tipo_pasajero}/destroy', [TipoPasajeroController::class, 'destroy'])->name('tipo_pasajero.destroy');

    Route::get('/dashboard/precio', [PrecioController::class, 'index'])->name('precio');
    Route::get('/dashboard/precio/create', [PrecioController::class, 'create'])->name('precio.create');
    Route::post('/dashboard/precio', [PrecioController::class, 'store'])->name('precio.store');
    Route::get('/dashboard/precio/{precio}/edit', [PrecioController::class, 'edit'])->name('precio.edit');
    Route::patch('/dashboard/precio/{precio}/update', [PrecioController::class, 'update'])->name('precio.update');
    Route::delete('/dashboard/precio/{precio}/destroy', [PrecioController::class, 'destroy'])->name('precio.destroy');

    Route::get('/dashboard/itinerario_destino', [ItinerarioDestinoController::class, 'index'])->name('itinerario_destino');
    Route::get('/dashboard/itinerario_destino/create', [ItinerarioDestinoController::class, 'create'])->name('itinerario_destino.create');
    Route::post('/dashboard/itinerario_destino', [ItinerarioDestinoController::class, 'store'])->name('itinerario_destino.store');
    Route::get('/dashboard/itinerario_destino/{itinerario_destino}/edit', [ItinerarioDestinoController::class, 'edit'])->name('itinerario_destino.edit');
    Route::patch('/dashboard/itinerario_destino/{itinerario_destino}/update', [ItinerarioDestinoController::class, 'update'])->name('itinerario_destino.update');
    Route::delete('/dashboard/itinerario_destino/{itinerario_destino}/destroy', [ItinerarioDestinoController::class, 'destroy'])->name('itinerario_destino.destroy');

    Route::get('/dashboard/itinerario_servicio', [ItinerarioServicioController::class, 'index'])->name('itinerario_servicio');
    Route::get('/dashboard/itinerario_servicio/create', [ItinerarioServicioController::class, 'create'])->name('itinerario_servicio.create');
    Route::post('/dashboard/itinerario_servicio', [ItinerarioServicioController::class, 'store'])->name('itinerario_servicio.store');
    Route::get('/dashboard/itinerario_servicio/{itinerario_servicio}/edit', [ItinerarioServicioController::class, 'edit'])->name('itinerario_servicio.edit');
    Route::patch('/dashboard/itinerario_servicio/{itinerario_servicio}/update', [ItinerarioServicioController::class, 'update'])->name('itinerario_servicio.update');
    Route::delete('/dashboard/itinerario_servicio/{itinerario_servicio}/destroy', [ItinerarioServicioController::class, 'destroy'])->name('itinerario_servicio.destroy');

    // Route::get('/dashboard/itinerario_destino', [PrecioController::class, 'index'])->name('itinerario_destino');
    // Route::get('/dashboard/itinerario_destino/create', [PrecioController::class, 'create'])->name('itinerario_destino.create');
    // Route::post('/dashboard/itinerario_destino', [PrecioController::class, 'store'])->name('itinerario_destino.store');
    // Route::get('/dashboard/itinerario_destino/{itinerario_destino}/edit', [PrecioController::class, 'edit'])->name('itinerario_destino.edit');
    // Route::patch('/dashboard/itinerario_destino/{itinerario_destino}/update', [PrecioController::class, 'update'])->name('itinerario_destino.update');
    // Route::delete('/dashboard/itinerario_destino/{itinerario_destino}/destroy', [PrecioController::class, 'destroy'])->name('itinerario_destino.destroy');

    Route::get('/dashboard/cotizacion', [CotizacionController::class, 'index'])->name('cotizacion');
    Route::get('/dashboard/cotizacion/opindex', [CotizacionController::class, 'opindex'])->name('cotizacion.opindex');
    Route::get('/dashboard/cotizacion/create', [CotizacionController::class, 'create'])->name('cotizacion.create');
    Route::post('/dashboard/cotizacion', [CotizacionController::class, 'store'])->name('cotizacion.store');
    Route::get('/dashboard/cotizacion/{cotizacion}/edit', [CotizacionController::class, 'edit'])->name('cotizacion.edit');
    Route::get('/dashboard/cotizacion/{cotizacion}/show', [CotizacionController::class, 'show'])->name('cotizacion.show');
    Route::patch('/dashboard/cotizacion/{cotizacion}/update', [CotizacionController::class, 'update'])->name('cotizacion.update');
    Route::delete('/dashboard/cotizacion/{cotizacion}/destroy', [CotizacionController::class, 'destroy'])->name('cotizacion.destroy');

    Route::get('/dashboard/pasajero', [PasajeroController::class, 'index'])->name('pasajero');
    Route::get('/dashboard/pasajero/create', [PasajeroController::class, 'create'])->name('pasajero.create');
    Route::post('/dashboard/pasajero/find', [PasajeroController::class, 'find'])->name('pasajero.find');
    Route::post('/dashboard/pasajero', [PasajeroController::class, 'store'])->name('pasajero.store');
    Route::get('/dashboard/pasajero/{pasajero}/edit', [PasajeroController::class, 'edit'])->name('pasajero.edit');
    Route::post('/dashboard/pasajero/{pasajero}/update', [PasajeroController::class, 'update'])->name('pasajero.update');
    Route::delete('/dashboard/pasajero/{pasajero}/destroy', [PasajeroController::class, 'destroy'])->name('pasajero.destroy');

    Route::get('/dashboard/idioma', [IdiomaController::class, 'index'])->name('idioma');
    Route::get('/dashboard/idioma/selectOptions', [IdiomaController::class, 'selectOptions'])->name('idioma.selectOptions'); 
    Route::get('/dashboard/idioma/create', [IdiomaController::class, 'create'])->name('idioma.create');
    Route::post('/dashboard/idioma', [IdiomaController::class, 'store'])->name('idioma.store');
    Route::get('/dashboard/idioma/{idioma}/edit', [IdiomaController::class, 'edit'])->name('idioma.edit');
    Route::patch('/dashboard/idioma/{idioma}/update', [IdiomaController::class, 'update'])->name('idioma.update');
    Route::delete('/dashboard/idioma/{idioma}/destroy', [IdiomaController::class, 'destroy'])->name('idioma.destroy');

    Route::get('/dashboard/mercado', [MercadoController::class, 'index'])->name('mercado');
    Route::get('/dashboard/mercado/selectOptions', [MercadoController::class, 'selectOptions'])->name('mercado.selectOptions'); 
    Route::get('/dashboard/mercado/create', [MercadoController::class, 'create'])->name('mercado.create');
    Route::post('/dashboard/mercado', [MercadoController::class, 'store'])->name('mercado.store');
    Route::get('/dashboard/mercado/{mercado}/edit', [MercadoController::class, 'edit'])->name('mercado.edit');
    Route::patch('/dashboard/mercado/{mercado}/update', [MercadoController::class, 'update'])->name('mercado.update');
    Route::delete('/dashboard/mercado/{mercado}/destroy', [MercadoController::class, 'destroy'])->name('mercado.destroy');

    Route::get('/dashboard/pasajero_servicio', [PasajeroServicioController::class, 'index'])->name('pasajero_servicio');
    Route::get('/dashboard/pasajero_servicio/create', [PasajeroServicioController::class, 'create'])->name('pasajero_servicio.create');
    Route::post('/dashboard/pasajero_servicio', [PasajeroServicioController::class, 'store'])->name('pasajero_servicio.store');
    Route::get('/dashboard/pasajero_servicio/{pasajero_servicio}/edit', [PasajeroServicioController::class, 'edit'])->name('pasajero_servicio.edit');
    Route::patch('/dashboard/pasajero_servicio/{pasajero_servicio}/update', [PasajeroServicioController::class, 'update'])->name('pasajero_servicio.update');
    Route::delete('/dashboard/pasajero_servicio/{pasajero_servicio}/destroy', [PasajeroServicioController::class, 'destroy'])->name('pasajero_servicio.destroy');

    Route::get('/dashboard/tipo_habitacion', [TipoHabitacionController::class, 'index'])->name('tipo_habitacion');
    Route::get('/dashboard/tipo_habitacion/create', [TipoHabitacionController::class, 'create'])->name('tipo_habitacion.create');
    Route::post('/dashboard/tipo_habitacion', [TipoHabitacionController::class, 'store'])->name('tipo_habitacion.store');
    Route::get('/dashboard/tipo_habitacion/{tipo_habitacion}/edit', [TipoHabitacionController::class, 'edit'])->name('tipo_habitacion.edit');
    Route::patch('/dashboard/tipo_habitacion/{tipo_habitacion}/update', [TipoHabitacionController::class, 'update'])->name('tipo_habitacion.update');
    Route::delete('/dashboard/tipo_habitacion/{tipo_habitacion}/destroy', [TipoHabitacionController::class, 'destroy'])->name('tipo_habitacion.destroy');
});
