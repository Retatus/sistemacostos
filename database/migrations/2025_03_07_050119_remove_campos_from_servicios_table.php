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
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn(['monto', 'moneda', 'tipo_pax', 'servicio_clase_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->decimal('monto', 10, 2);
            $table->enum('moneda', ['DOLARES', 'SOLES'])->default('DOLARES');
            $table->enum('tipo_pax', ['ADULTO', 'ESTUDIANTE', 'NINIO'])->default('ADULTO');
            $table->integer('servicio_clase_id');
        });
    }
};
