<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->unique()->constrained('pelanggan_pbpd')->cascadeOnDelete();
            $table->string('jenis_perluasan', 20);
            $table->string('jenis_tiang', 30)->nullable();
            $table->unsignedInteger('jml_tiang')->nullable();
            $table->unsignedInteger('jml_konduktor')->nullable();
            $table->string('jenis_trafo', 30)->nullable();
            $table->unsignedInteger('jml_trafo')->nullable();
            $table->unsignedInteger('jml_kwh_meter')->nullable();
            $table->foreignId('dikirim_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dikirim_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_material');
    }
};
