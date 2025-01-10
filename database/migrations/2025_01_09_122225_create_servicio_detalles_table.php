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
            $table->string('descripcion', 75);
            $table->string('costo', 15);
            $table->enum('destino', ['113', '107', '210'])->default('113');
            $table->enum('distribucion', ['exportacion', 'intangibles', 'doc de cobranza'])->default('exportacion');
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
