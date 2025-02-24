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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('proveedor_id');

            // Define la relación con la tabla `proveedors`
            $table->foreign('proveedor_id')
                ->references('id')->on('proveedors')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('file_nro', 10);
            $table->string('file_nombre', 25);
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('comprobante_id');

            // Define la relación con la tabla `tipo_documentos`
            $table->foreign('comprobante_id')
                ->references('id')->on('tipo_documentos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->date('fecha')->nullable();
            $table->integer('nro_pasajeros');
            $table->integer('nro_ninio');
            $table->integer('nro_adulto');
            $table->integer('nro_estudiante');
            $table->integer('idioma');
            $table->integer('mercado');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('destino_turistico_id');

            // Define la relación con la tabla `destino_turisticos`
            $table->foreign('destino_turistico_id')
                ->references('id')->on('destino_turisticos')
                ->onUpdate('cascade')->onDelete('cascade');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('pais_id');

            // Define la relación con la tabla `pais`
            $table->foreign('pais_id')
                ->references('id')->on('pais')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('nro_dias');
            $table->tinyInteger('estado_cotizacion' )->default(1);
            $table->decimal('costo_parcial', 10, 2);
            $table->decimal('descuento_estudiante', 10, 2);
            $table->decimal('descuento_ninio', 10, 2);
            $table->decimal('descuento_otro', 10, 2);
            $table->decimal('costo_total', 10, 2);
            $table->tinyInteger('estado_activo' )->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacions');
    }
};
