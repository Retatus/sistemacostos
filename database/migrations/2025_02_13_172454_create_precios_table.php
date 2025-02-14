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
        Schema::create('precios', function (Blueprint $table) {
            $table->id();
            $table->string('anio', 4);
            $table->enum('moneda', ['DOLARES', 'SOLES'])->default('DOLARES');
            $table->decimal('monto', 10, 2);
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('tipo_pasajero_id');

            // Define la relación con la tabla `tipo_pasajeros`
            $table->foreign('tipo_pasajero_id')
                ->references('id')->on('tipo_pasajeros')
                ->onUpdate('cascade')->onDelete('cascade');
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('servicio_id');

            // Define la relación con la tabla `servicios`
            $table->foreign('servicio_id')
                ->references('id')->on('servicios')
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
        Schema::dropIfExists('precios');
    }
};
