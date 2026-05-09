<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotizacionApiController;
use App\Http\Controllers\DestinoTuristicoController;

// -------------------------------
//  RUTAS API PARA COTIZACIONES
// -------------------------------
Route::prefix('cotizaciones')->group(function () {

    // GET /api/cotizaciones/destinos/destino_select
    Route::get('destino/destino_select', [CotizacionApiController::class, 'destino_select']);

    // GET /api/cotizaciones/destinos/search?search=...
    Route::get('destino/destino_search', [CotizacionApiController::class, 'destino_search']);

    //GET /api/cotizaciones/destino/{id}
    Route::get('destino/{id}', [CotizacionApiController::class, 'destino']);

    // Crear estructura inicial basada en un destino (plantilla)
    Route::get('create', [CotizacionApiController::class, 'create']);

    // Guardar nueva cotización
    Route::post('/', [CotizacionApiController::class, 'store']);

    // Cargar cotización para editar
    Route::get('{cotizacion}/edit', [CotizacionApiController::class, 'edit']);

    // Actualizar cotización existente
    Route::put('{cotizacion}', [CotizacionApiController::class, 'update']);

    // Opcional: listar
    Route::get('/', [CotizacionApiController::class, 'index']);

    // Opcional: mostrar una cotización
    Route::get('{cotizacion}', [CotizacionApiController::class, 'show']);

    // Opcional: eliminar
    Route::delete('{cotizacion}', [CotizacionApiController::class, 'destroy']);
});

Route::post('/dashboard/destino_turistico/destinoServicios', [DestinoTuristicoController::class, 'destinoServicios'])->name('destino_turistico.destinoServicios'); 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

