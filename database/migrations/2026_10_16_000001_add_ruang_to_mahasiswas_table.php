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
        if (!Schema::hasColumn('mahasiswas', 'ruang')) {
            Schema::table('mahasiswas', function (Blueprint $table) {
                $table->string('ruang')->default('public')->after('id')->index();
            });

            Schema::table('mahasiswas', function (Blueprint $table) {
                try {
                    $table->dropUnique(['nim']);
                } catch (\Throwable $e) {
                    // Ignore if index was not named mahasiswas_nim_unique
                }

                try {
                    $table->unique(['ruang', 'nim'], 'mahasiswas_ruang_nim_unique');
                } catch (\Throwable $e) {
                    // Ignore if already unique
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('mahasiswas', 'ruang')) {
            Schema::table('mahasiswas', function (Blueprint $table) {
                try {
                    $table->dropUnique('mahasiswas_ruang_nim_unique');
                } catch (\Throwable $e) {}

                try {
                    $table->unique('nim');
                } catch (\Throwable $e) {}

                $table->dropColumn('ruang');
            });
        }
    }
};
