<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->dropUnique(['no_agenda']);
            $table->unique(['no_agenda', 'ulp_id']);
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan_pbpd', function (Blueprint $table) {
            $table->dropUnique(['no_agenda', 'ulp_id']);
            $table->unique('no_agenda');
        });
    }
};
