<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->decimal('total_biaya', 15, 2)->nullable()->after('rab');
            $table->date('tgl_mohon')->nullable()->after('total_biaya');
            $table->date('tgl_bayar')->nullable()->after('tgl_mohon');
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->dropColumn(['total_biaya', 'tgl_mohon', 'tgl_bayar']);
        });
    }
};
