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
            // Comportamiento del cálculo
            $table->enum('tipo_costo', ['UNITARIO', 'GRUPAL', 'HABITACION'])->default('UNITARIO')->after('servicio_id');
            // Definición de escalas por número de pasajeros
            $table->integer('pax_min')->default(1)->after('tipo_costo');
            $table->integer('pax_max')->default(99)->after('pax_min');
            // Capacidad para hoteles
            $table->integer('capacidad_pax')->default(1)->after('pax_max');
            
            $table->index(['pax_min', 'pax_max'], 'idx_rangos_pax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('precios', function (Blueprint $table) {
            $table->dropColumn(['tipo_costo', 'pax_min', 'pax_max', 'capacidad_pax']);
            $table->dropIndex('idx_rangos_pax');
        });
    }
};
