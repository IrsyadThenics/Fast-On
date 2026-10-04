<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->unique()->constrained('pelanggan_pbpd')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->boolean('pekerjaan_lengkap')->default(false);
            $table->boolean('pekerjaan_sesuai_wo')->default(false);
            $table->boolean('foto_terlampir')->default(false);
            $table->boolean('siap_dilanjutkan')->default(false);
            $table->text('catatan')->nullable();
            $table->json('berkas_paths')->nullable();
            $table->foreignId('dikirim_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamp('dikirim_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_vendor');
    }
};
