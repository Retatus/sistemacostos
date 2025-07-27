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
            $table->enum('moneda', ['USD', 'PEN'])->default('USD')->after('observacion');
            $table->decimal('monto', 10, 2)->default(0.00)->after('moneda');
            $table->tinyInteger('estatus')->default(0)->after('monto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajero_servicios', function (Blueprint $table) {
            $table->dropColumn('moneda');
            $table->dropColumn('monto');
            $table->dropColumn('estatus');
        });
    }
};
