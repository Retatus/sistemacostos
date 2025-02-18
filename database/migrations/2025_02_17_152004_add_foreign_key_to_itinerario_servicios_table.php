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
        Schema::table('itinerario_servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('itinerario_destino_id')->change(); // Asegúrate de que el campo sea del tipo correcto.
            $table->foreign('itinerario_destino_id')
                ->references('id')
                ->on('itinerario_destinos')
                ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itinerario_servicios', function (Blueprint $table) {
            $table->dropForeign(['itinerario_destino_id']);
        });
    }
};
