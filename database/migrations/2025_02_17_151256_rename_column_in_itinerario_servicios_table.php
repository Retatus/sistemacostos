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
        Schema::table('itinerario_servicios', function (Blueprint $table) {
            $table->renameColumn('itinerario_id', 'itinerario_destino_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itinerario_servicios', function (Blueprint $table) {
            $table->renameColumn('itinerario_destino_id', 'itinerario_id');
        });
    }
};
