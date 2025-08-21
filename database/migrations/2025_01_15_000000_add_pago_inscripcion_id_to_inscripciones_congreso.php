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
        Schema::table('inscripciones_congreso', function (Blueprint $table) {
            $table->foreignId('pago_inscripcion_id')->nullable()->after('convocatoria_congreso_id')->constrained('pagos_inscripcion_congreso')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripciones_congreso', function (Blueprint $table) {
            $table->dropForeign(['pago_inscripcion_id']);
            $table->dropColumn('pago_inscripcion_id');
        });
    }
};