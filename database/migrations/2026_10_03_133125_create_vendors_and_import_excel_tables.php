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
    Schema::create('vendors', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->string('jenis', 15); // TIANG / KONSTRUKSI
    });

    Schema::create('import_excel', function (Blueprint $table) {
        $table->id();
        $table->string('file_name', 255);
        $table->foreignId('uploaded_by')->constrained('users');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('import_excel');
    Schema::dropIfExists('vendors');
}
};
