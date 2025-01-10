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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_pax', ['adulto', 'estudiante', 'ninio'])->default('adulto');
            $table->enum('moneda', ['soles', 'dolares'])->default('soles');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('proveedor_id');

            // Define la relación con la tabla `proveedor_categorias`
            $table->foreign('priveedor_id')
                ->references('id')->on('proveedor_categorias')
                ->onUpdate('cascade')->onDelete('cascade');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('servicio_detalle_id');

            // Define la relación con la tabla `servicio_detalles`
            $table->foreign('servicio_detalle_id')
                ->references('id')->on('servicio_detalles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('ubicacion', 45);
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('servicio_clase_id');

            // Define la relación con la tabla `servicio_clases`
            $table->foreign('servicio_clase_id')
                ->references('id')->on('servicio_clases')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
