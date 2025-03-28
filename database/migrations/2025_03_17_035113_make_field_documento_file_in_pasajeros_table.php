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
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->string('documento_file')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->string('documento_file')->nullable(false)->change();
        });
    }
};
