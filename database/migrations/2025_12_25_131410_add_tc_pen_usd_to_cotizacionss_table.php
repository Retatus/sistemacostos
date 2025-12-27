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
        Schema::table('cotizacions', function (Blueprint $table) {
            // Totales por moneda (Evita errores de redondeo)
            $table->decimal('total_pen', 12, 2)->default(0.00)->after('estado_cotizacion');
            $table->decimal('total_usd', 12, 2)->default(0.00)->after('total_pen');
            // Tipo de cambio histórico (Crucial para 2025)
            $table->decimal('tipo_cambio', 10, 3)->default(1.000)->after('total_usd');
            // Configuración de vista
            $table->enum('moneda_resumen', ['USD', 'PEN'])->default('USD')->after('tipo_cambio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropColumn(['tipo_cambio', 'total_pen', 'total_usd', 'moneda_resumen']);
        });
    }
};
