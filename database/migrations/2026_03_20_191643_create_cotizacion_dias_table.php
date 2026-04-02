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
        Schema::create('cotizacion_dias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cotizacion_id')
                ->constrained('cotizacions')
                ->cascadeOnDelete();

            $table->integer('dia');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado_activo' )->default(1);

            $table->timestamps();

            // 🔥 evita duplicar días en una misma cotización
            $table->unique(['cotizacion_id', 'dia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_dias');
    }
};
