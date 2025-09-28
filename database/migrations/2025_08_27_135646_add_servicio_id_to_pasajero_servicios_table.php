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
            $table->unsignedBigInteger('servicio_id')->nullable()->after('itinerario_servicio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            $table->dropColumn('servicio_id');
        });
    }    
};