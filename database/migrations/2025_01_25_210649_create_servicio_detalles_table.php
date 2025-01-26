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
        Schema::create('servicio_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('proveedor_categoria_id');

            // Define la relación con la tabla `proveedor_categorias`
            $table->foreign('proveedor_categoria_id')
                ->references('id')->on('proveedor_categorias')
                ->onUpdate('cascade')->onDelete('cascade');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('costo_id');

            // Define la relación con la tabla `costos`
            $table->foreign('costo_id')
                ->references('id')->on('costos')
                ->onUpdate('cascade')->onDelete('cascade');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('destino_id');

            // Define la relación con la tabla `destinos`
            $table->foreign('destino_id')
                ->references('id')->on('destinos')
                ->onUpdate('cascade')->onDelete('cascade');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('distribucion_venta_id');

            // Define la relación con la tabla `distribucion_ventas`
            $table->foreign('distribucion_venta_id')
                ->references('id')->on('distribucion_ventas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('estado_activo' )->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_detalles');
    }
};
