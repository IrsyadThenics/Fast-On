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
    Schema::create('pelanggan_pbpd', function (Blueprint $table) {
        $table->id();
        $table->foreignId('import_id')->nullable()->constrained('import_excel')->nullOnDelete();
        $table->foreignId('ulp_id')->constrained('ulp');
        $table->string('asal_ulp', 50)->nullable();
        $table->decimal('no_agenda', 20, 0)->unique();
        $table->decimal('id_pelanggan', 20, 0)->nullable();
        $table->string('nama_pelanggan', 100)->nullable();
        $table->string('alamat', 255)->nullable();
        $table->string('tarif_lama', 10)->nullable();
        $table->string('daya_lama', 10)->nullable();
        $table->string('tarif_baru', 10)->nullable();
        $table->string('daya_baru', 10)->nullable();
        $table->string('keterangan', 100)->nullable();
        $table->string('status', 10)->nullable();
        $table->string('jenis_transaksi', 15)->nullable(); // PB / PD
        $table->string('tahap', 20)->default('ULP');
        $table->timestamps();

        $table->index(['tahap', 'ulp_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('pelanggan_pbpd');
}
};
