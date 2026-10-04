<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->decimal('bp', 15, 2)->nullable()->after('id_pelanggan');
            $table->decimal('rab', 15, 2)->nullable()->after('bp');
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->dropColumn(['bp', 'rab']);
        });
    }
};
