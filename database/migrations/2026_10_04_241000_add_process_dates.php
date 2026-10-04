<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->timestamp('hasil_konstruksi_at')->nullable();
            $table->timestamp('hasil_transaksi_at')->nullable();
            $table->timestamp('hasil_jaringan_at')->nullable();
        });
        Schema::table('laporan_vendor', function (Blueprint $table) {
            $table->timestamp('berkas_hasil_at')->nullable();
        });
        Schema::table('pengiriman_konstruksi', function (Blueprint $table) {
            $table->timestamp('hasil_perencanaan_at')->nullable();
            $table->timestamp('hasil_konstruksi_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->dropColumn(['hasil_konstruksi_at', 'hasil_transaksi_at', 'hasil_jaringan_at']);
        });
        Schema::table('laporan_vendor', function (Blueprint $table) {
            $table->dropColumn('berkas_hasil_at');
        });
        Schema::table('pengiriman_konstruksi', function (Blueprint $table) {
            $table->dropColumn(['hasil_perencanaan_at', 'hasil_konstruksi_at']);
        });
    }
};
