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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 15);
            $table->string('razon_social', 100);
            $table->string('direccion', 100);
            $table->string('tipo_comprobante', 25);
            $table->string('correo', 100);
            $table->string('tipo_sunat', 25);
            $table->string('contacto', 50);
            $table->tinyInteger('estado_activo' )->default(1);
             

            // Define la columna que será la clave foránea
            $table->unsignedBigInteger('proveedor_categoria_id');

            // Define la relación con la tabla `proveedor_categorias`
            $table->foreign('proveedor_categoria_id')
                ->references('id')->on('proveedor_categorias')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
