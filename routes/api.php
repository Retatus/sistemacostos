<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotizacionApiController;

// -------------------------------
//  RUTAS API PARA COTIZACIONES
// -------------------------------
Route::prefix('cotizaciones')->group(function () {

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

