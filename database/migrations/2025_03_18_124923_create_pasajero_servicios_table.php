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
        Schema::create('pasajero_servicios', function (Blueprint $table) {
            $table->id();
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('pasajero_id');

            // Define la relación con la tabla `pasajeros`
            $table->foreign('pasajero_id')
                ->references('id')->on('pasajeros')
                ->onUpdate('cascade')->onDelete('cascade');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('itinerario_servicio_id');

            // Define la relación con la tabla `itinerario_servicios`
            $table->foreign('itinerario_servicio_id')
                ->references('id')->on('itinerario_servicios')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('estado_activo' )->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajero_servicios');
    }
};
