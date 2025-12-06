<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar registros donde observacion contiene 'SOLES'
        DB::table('itinerario_servicios')
            ->where('observacion', 'like', '%SOLES%')
            ->update(['moneda' => 'PEN']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si quieres revertir, puedes volver a USD (o dejarlo vacío)
        DB::table('itinerario_servicios')
            ->where('observacion', 'like', '%SOLES%')
            ->update(['moneda' => 'USD']);
    }
};
