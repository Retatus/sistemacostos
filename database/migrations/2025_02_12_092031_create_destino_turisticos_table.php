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
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('pais');

            // Define la relación con la tabla `pais`
            $table->foreign('pais')
                ->references('id')->on('pais')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('nro_dias');
            $table->decimal('costo_total', 10, 2);
            $table->integer('margen');
            $table->decimal('ganancia', 10, 2);
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
