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
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('pasajero_id')->nullable()->change();
            $table->unsignedBigInteger('itinerario_servicio_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('pasajero_id')->nullable(false)->change();
            $table->unsignedBigInteger('itinerario_servicio_id')->nullable(false)->change();
        });
    }
};
