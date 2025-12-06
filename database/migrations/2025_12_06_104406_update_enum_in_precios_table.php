<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Paso 1: ampliar temporalmente el enum para aceptar valores viejos y nuevos
        Schema::table('precios', function (Blueprint $table) {
            $table->enum('moneda', ['DOLARES', 'SOLES', 'USD', 'PEN'])->change();
        });

        // Paso 2: actualizar los registros existentes
        DB::table('precios')
            ->where('moneda', 'DOLARES')
            ->update(['moneda' => 'USD']);

        DB::table('precios')
            ->where('moneda', 'SOLES')
            ->update(['moneda' => 'PEN']);

        // Paso 3: reducir el enum para dejar solo los nuevos valores
        Schema::table('precios', function (Blueprint $table) {
            $table->enum('moneda', ['USD', 'PEN'])->default('USD')->change();
        });
    }

    public function down(): void
    {
        // Paso 1: ampliar temporalmente el enum para aceptar valores viejos y nuevos
        Schema::table('precios', function (Blueprint $table) {
            $table->enum('moneda', ['USD', 'PEN', 'DOLARES', 'SOLES'])->change();
        });

        // Paso 2: revertir los registros
        DB::table('precios')
            ->where('moneda', 'USD')
            ->update(['moneda' => 'DOLARES']);

        DB::table('precios')
            ->where('moneda', 'PEN')
            ->update(['moneda' => 'SOLES']);

        // Paso 3: reducir el enum para dejar solo los valores originales
        Schema::table('precios', function (Blueprint $table) {
            $table->enum('moneda', ['DOLARES', 'SOLES'])->default('DOLARES')->change();
        });
    }
};