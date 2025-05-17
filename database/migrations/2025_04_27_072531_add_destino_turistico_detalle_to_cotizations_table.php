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
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->json('destino_turistico_detalle')->nullable()->after('destino_turistico_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropColumn('destino_turistico_detalle');
        });
    }
};
