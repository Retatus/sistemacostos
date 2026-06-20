<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial_cambios', function (Blueprint $table) {
            $table->id();

            // Entidad afectada
            $table->string('entidad'); // Ej: "Cotizacion", "Servicio", "Pasajero"
            $table->unsignedBigInteger('entidad_id')->nullable();

            // Campo afectado
            $table->string('campo'); // Ej: "precio_unitario"
            $table->string('ruta')->nullable(); // Ej: "dias[0].servicios[2].precio_unitario"

            // Valores antes y después
            $table->json('valor_anterior')->nullable();
            $table->json('valor_nuevo')->nullable();

            // Usuario que hizo el cambio
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Tipo de acción
            $table->string('accion'); // crear, actualizar, eliminar, restaurar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_cambios');
    }
};
