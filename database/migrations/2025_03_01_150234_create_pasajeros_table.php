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
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 25);
            $table->string('apellido_paterno', 25);
            $table->string('apellido_materno', 25);
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('documento_tipo_id');

            // Define la relación con la tabla `tipo_documentos`
            $table->foreign('documento_tipo_id')
                ->references('id')->on('tipo_documentos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('documento_numero', 15);
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('pais_id');

            // Define la relación con la tabla `pais`
            $table->foreign('pais_id')
                ->references('id')->on('pais')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('documento_file', 225);
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('tipo_pasajero_id');

            // Define la relación con la tabla `tipo_pasajeros`
            $table->foreign('tipo_pasajero_id')
                ->references('id')->on('tipo_pasajeros')
                ->onUpdate('cascade')->onDelete('cascade');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('clase_id');

            // Define la relación con la tabla `servicio_clases`
            $table->foreign('clase_id')
                ->references('id')->on('servicio_clases')
                ->onUpdate('cascade')->onDelete('cascade');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('cotizacion_id');

            // Define la relación con la tabla `cotizacions`
            $table->foreign('cotizacion_id')
                ->references('id')->on('cotizacions')
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
        Schema::dropIfExists('pasajeros');
    }
};
