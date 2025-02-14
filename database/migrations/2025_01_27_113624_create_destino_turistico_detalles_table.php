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
        Schema::create('destino_turistico_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_dia');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado_activo' )->default(1);
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('destino_turistico_id');

            // Define la relación con la tabla `destino_turisticos`
            $table->foreign('destino_turistico_id')
                ->references('id')->on('destino_turisticos')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destino_turistico_detalles');
    }
};
