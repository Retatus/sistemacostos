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
        Schema::create('cotizacion_servicio_pasajeros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cotizacion_servicio_id')->constrained('cotizacion_servicios')->cascadeOnDelete();
            $table->foreignId('pasajero_id')->constrained('pasajeros')->cascadeOnDelete();

            $table->decimal('precio', 12, 2)->default(0);
            $table->unsignedInteger('cantidad')->default(1);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);

            $table->boolean('estado')->default(true);

            $table->timestamps();

            // Definimos nombres cortos personalizados para evitar el límite de 64 caracteres
            $table->unique(['cotizacion_servicio_id', 'pasajero_id'], 'cotiz_serv_pasaj_unique');
            $table->index(['cotizacion_servicio_id', 'pasajero_id'], 'cotiz_serv_pasaj_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_servicio_pasajeros');
    }
};
