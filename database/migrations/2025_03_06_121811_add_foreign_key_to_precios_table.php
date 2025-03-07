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
        Schema::table('precios', function (Blueprint $table) {
            $table->unsignedBigInteger('servicio_clase_id')->change(); // Asegúrate de que el campo sea del tipo correcto.
            $table->foreign('servicio_clase_id')
                ->references('id')
                ->on('servicio_clases')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('precios', function (Blueprint $table) {
            $table->dropForeign(['servicio_clase_id']);
        });
    }
};
