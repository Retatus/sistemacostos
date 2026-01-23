<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    public function up(): void
    {
        DB::statement("
            ALTER TABLE precios 
            MODIFY COLUMN tipo_costo 
            ENUM(
                'UNITARIO',
                'GRUPAL',
                'HABITACION',
                'HORA',
                'DIA',
                'TRAYECTO',
                'INGRESO',
                'ALIMENTACION',
                'GUIA'
            )
            NOT NULL 
            DEFAULT 'UNITARIO'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE precios 
            MODIFY COLUMN tipo_costo 
            ENUM(
                'UNITARIO',
                'GRUPAL',
                'HABITACION'
            )
            NOT NULL 
            DEFAULT 'UNITARIO'
        ");
    }
};
