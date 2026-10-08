<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE roles DROP CONSTRAINT IF EXISTS roles_type_check');
        DB::statement("ALTER TABLE roles ADD CONSTRAINT roles_type_check CHECK (type IN ('ULP', 'UP3', 'VENDOR'))");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE roles DROP CONSTRAINT IF EXISTS roles_type_check');
        DB::statement("ALTER TABLE roles ADD CONSTRAINT roles_type_check CHECK (type IN ('ULP', 'UP3'))");
    }
};
