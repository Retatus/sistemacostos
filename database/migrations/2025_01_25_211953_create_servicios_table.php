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
            $table->decimal('monto', 10, 2);
            $table->enum('moneda', ['DOLARES', 'SOLES'])->default('DOLARES');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('proveedor_id');

            // Define la relación con la tabla `proveedors`
            $table->foreign('proveedor_id')
                ->references('id')->on('proveedors')
                ->onUpdate('cascade')->onDelete('cascade');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('servicio_detalle_id');

            // Define la relación con la tabla `servicio_detalles`
            $table->foreign('servicio_detalle_id')
                ->references('id')->on('servicio_detalles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('ubicacion', 50);
            $table->enum('tipo_pax', ['ADULTO', 'ESTUDIANTE', 'NINIO'])->default('ADULTO');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('servicio_clase_id');

            // Define la relación con la tabla `servicio_clases`
            $table->foreign('servicio_clase_id')
                ->references('id')->on('servicio_clases')
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
        Schema::dropIfExists('servicios');
    }
};
