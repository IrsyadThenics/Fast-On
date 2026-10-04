<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->unique()->constrained('pelanggan_pbpd')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('status_kelayakan', 20);
            $table->string('wo_tiang_path', 255)->nullable();
            $table->foreignId('dikirim_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamp('dikirim_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman_vendor');
    }
};
