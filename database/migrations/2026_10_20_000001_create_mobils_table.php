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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('ruang', 100)->default('public')->index();
            $table->string('nama', 150);
            $table->string('brand', 100)->index();
            $table->unsignedBigInteger('harga')->index();
            $table->unsignedSmallInteger('tahun')->index();
            $table->string('transmisi', 50)->index();
            $table->string('bahan_bakar', 50)->index();
            $table->string('status', 30)->default('tersedia')->index();
            $table->text('foto')->nullable();
            $table->timestamps();

            // Index komposit untuk query pencarian ruang & filter
            $table->index(['ruang', 'brand']);
            $table->index(['ruang', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
