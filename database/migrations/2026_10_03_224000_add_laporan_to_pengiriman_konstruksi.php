<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengiriman_konstruksi', function (Blueprint $table) {
            $table->boolean('pekerjaan_lengkap')->nullable();
            $table->boolean('pekerjaan_sesuai_wo')->nullable();
            $table->boolean('foto_terlampir')->nullable();
            $table->boolean('siap_dilanjutkan')->nullable();
            $table->text('catatan')->nullable();
            $table->json('laporan_paths')->nullable();
            $table->timestamp('laporan_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pengiriman_konstruksi', function (Blueprint $table) {
            $table->dropColumn([
                'pekerjaan_lengkap', 'pekerjaan_sesuai_wo', 'foto_terlampir',
                'siap_dilanjutkan', 'catatan', 'laporan_paths', 'laporan_at',
            ]);
        });
    }
};
