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
        Schema::create('cotizacion_servicios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cotizacion_id')->constrained('cotizacions')->cascadeOnDelete();
            $table->foreignId('cotizacion_dia_id')->constrained('cotizacion_dias')->cascadeOnDelete();

            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedors')->nullOnDelete();

            // Estructura
            $table->unsignedInteger('orden')->default(0); // nro_orden
            $table->time('hora')->nullable();

            // Información editable
            $table->string('nombre_servicio');
            $table->text('observacion')->nullable();

            // Lógica de negocio
            $table->foreignId('tipo_costo_id')->nullable()->constrained('costos')->nullOnDelete();
            $table->foreignId('tipo_habitacion_id')->nullable()->constrained('tipo_habitacions')->nullOnDelete();

            // Precios
            $table->foreignId('precio_id')->nullable()->constrained('precios')->nullOnDelete();

            $table->enum('moneda', ['USD','PEN'])->default('USD');
            $table->decimal('precio_unitario', 12, 2)->default(0);

            $table->unsignedInteger('cantidad')->default(1);
            $table->unsignedInteger('capacidad')->nullable();

            $table->decimal('subtotal', 14, 2)->default(0);

            $table->boolean('estado_activo')->default(true);

            $table->timestamps();

            $table->index(['cotizacion_id','cotizacion_dia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_servicios');
    }
};
