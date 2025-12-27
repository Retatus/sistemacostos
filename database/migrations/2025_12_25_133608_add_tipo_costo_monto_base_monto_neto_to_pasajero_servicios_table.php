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
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            // 1. Trazabilidad del cálculo
            $table->enum('tipo_costo_aplicado', ['UNITARIO', 'GRUPAL', 'HABITACION'])
                  ->default('UNITARIO')
                  ->after('observacion');

            // 2. El precio bruto del tarifario (Precio del Recurso)
            // Si la Van cuesta 300, aquí guardas 300.
            $table->decimal('monto_base_tarifario', 12, 2)->default(0.00)->after('tipo_costo_aplicado');

            // 3. El resultado del prorrateo (Precio por Persona)
            // Si son 4 pasajeros y la Van cuesta 300, aquí guardas 75.00.
            $table->decimal('monto_neto_pax', 12, 2)->default(0.00)->after('monto_base_tarifario');

            // 4. Relación con el registro de precio original
            // Útil para saber qué tarifa de 2025 se usó.
            $table->unsignedBigInteger('precio')->nullable()->after('monto_neto_pax');                      
            
            // 5. Cantidad de unidades (Solo para lógica de Habitación)
            // Si el sistema calculó "3 habitaciones dobles", aquí guardas el 3.
            $table->integer('cantidad_unidades')->default(1)->after('precio');

            // 6. Gestión de descuentos
            $table->decimal('descuento_aplicado', 12, 2)->default(0.00)->after('cantidad_unidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_costo_aplicado', 
                'monto_base_tarifario', 
                'monto_neto_pax', 
                'descuento_aplicado', 
                'precio',
                'cantidad_unidades'
            ]);
        });
    }
};
