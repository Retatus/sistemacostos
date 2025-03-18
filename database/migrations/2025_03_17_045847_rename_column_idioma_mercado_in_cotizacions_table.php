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
            $table->renameColumn('idioma', 'idioma_id');
            $table->renameColumn('mercado', 'mercado_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->renameColumn('idioma_id', 'idioma');
            $table->renameColumn('mercado_id', 'mercado');
        });
    }
};
