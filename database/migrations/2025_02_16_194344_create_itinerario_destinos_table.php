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
        Schema::create('itinerario_destinos', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_dia');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('itinerario_id');

            // Define la relación con la tabla `itinerarios`
            $table->foreign('itinerario_id')
                ->references('id')->on('itinerarios')
                ->onUpdate('cascade')->onDelete('cascade');
             
            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('destino_turistico_id');

            // Define la relación con la tabla `destino_turisticos`
            $table->foreign('destino_turistico_id')
                ->references('id')->on('destino_turisticos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nombre', 45);
            $table->text('descripcion')->nullable()->default('');
            $table->string('observacion', 100);
            $table->tinyInteger('estado_activo' )->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerario_destinos');
    }
};
