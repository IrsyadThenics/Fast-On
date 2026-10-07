<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_material', function (Blueprint $table) {
            $table->string('jenis_panel_meter', 30)->nullable()->after('jenis_kwh_meter');
            $table->unsignedInteger('jml_panel_meter')->nullable()->after('jenis_panel_meter');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_material', function (Blueprint $table) {
            $table->dropColumn(['jenis_panel_meter', 'jml_panel_meter']);
        });
    }
};
