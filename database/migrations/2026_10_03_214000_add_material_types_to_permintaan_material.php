<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_material', function (Blueprint $table) {
            $table->string('jenis_konduktor', 30)->nullable()->after('jml_konduktor');
            $table->string('jenis_kwh_meter', 30)->nullable()->after('jml_kwh_meter');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_material', function (Blueprint $table) {
            $table->dropColumn(['jenis_konduktor', 'jenis_kwh_meter']);
        });
    }
};
