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
            $table->integer('nro_orden')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            $table->dropColumn('nro_orden');
        });
    }
};
