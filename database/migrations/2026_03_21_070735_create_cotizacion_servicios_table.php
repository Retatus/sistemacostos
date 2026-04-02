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

            // 🔥 RELACIÓN REAL
            $table->foreignId('cotizacion_dia_id')
                ->constrained('cotizacion_dias')
                ->cascadeOnDelete();

            $table->foreignId('servicio_id')
                ->nullable()
                ->constrained('servicios')
                ->nullOnDelete();

            $table->foreignId('proveedor_id')
                ->nullable()
                ->constrained('proveedors')
                ->nullOnDelete();

            $table->unsignedInteger('orden')->default(1);
            $table->time('hora')->nullable();

            $table->string('nombre_servicio', 100);
            $table->text('observacion')->nullable();

            $table->foreignId('tipo_costo_id')
                ->constrained('tipo_costos');

            $table->foreignId('tipo_habitacion_id')
                ->nullable()
                ->constrained('tipo_habitacions')
                ->nullOnDelete();

            $table->foreignId('precio_id')
                ->nullable()
                ->constrained('precios')
                ->nullOnDelete();

            $table->enum('moneda', ['USD', 'PEN']);

            $table->decimal('precio_unitario', 12, 2)->nullable();

            $table->unsignedInteger('cantidad')->default(1);
            $table->unsignedInteger('capacidad')->nullable();

            $table->decimal('subtotal', 14, 2)->default(0);

            $table->tinyInteger('estado_activo')->default(1);

            $table->timestamps();

            // 🔥 optimización consultas
            $table->index(['cotizacion_dia_id', 'orden']);
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
