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
            $table->integer('proveedor_id')->default(0)->after('itinerario_destino_id');
            $table->integer('proveedor_categoria_id')->default(0)->after('itinerario_destino_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itinerario_servicios', function (Blueprint $table) {
            $table->dropColumn('proveedor_id');
            $table->dropColumn('proveedor_categoria_id');
        });
    }
};
