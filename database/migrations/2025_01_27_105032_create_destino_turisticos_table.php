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
        Schema::create('destino_turisticos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('pais', 25);
            $table->integer('dias');
            $table->decimal('costo_total', 10, 2);
            $table->enum('descuento_tipo', ['0', '1'])->default('0');
            $table->decimal('descuento_estudiante', 10, 2);
            $table->decimal('descuento_ninio', 10, 2);
            $table->decimal('descuento_otros', 10, 2);
            $table->integer('margen');
            $table->decimal('venta', 10, 2);
            $table->tinyInteger('estado_activo' )->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destino_turisticos');
    }
};
