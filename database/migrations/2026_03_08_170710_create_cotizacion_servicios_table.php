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
            $table->integer('nro_dia')->nullable();
            $table->integer('nro_orden')->nullable();
            $table->string('hora',5)->default('00:00')->nullable();

            $table->foreignId('itinerario_servicio_id')
                ->nullable()
                ->constrained('itinerario_servicios')
                ->nullOnDelete();

            $table->foreignId('cotizacion_id')
                ->constrained('cotizacions')
                ->cascadeOnDelete();

            $table->foreignId('precio_id')
                ->nullable()
                ->constrained('precios')
                ->nullOnDelete();

            $table->enum('moneda', ['USD', 'PEN'])->default('USD');
            $table->decimal('precio_unitario', 12, 2)->nullable();
            $table->integer('cantidad')->default(1);
            $table->integer('capacidad')->nullable();

            $table->foreignId('tipo_habitacion_id')
                ->nullable()
                ->constrained('tipo_habitacions')
                ->nullOnDelete();

            $table->decimal('subtotal',12,2)->default(0);
            $table->string('observacion')->nullable();

            $table->foreignId('tipo_costo_id')
                ->nullable()
                ->constrained('tipo_costos')
                ->nullOnDelete();

            $table->tinyInteger('estado_activo' )->default(1);
            $table->timestamps();
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
