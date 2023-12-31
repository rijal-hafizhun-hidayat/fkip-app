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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nim');
            $table->bigInteger('id_guru_pamong')->nullable();
            $table->bigInteger('id_dpl')->nullable();
            $table->string('nama');
            $table->string('prodi');
            $table->string('jenis_plp');
            $table->json('nilai_kompeten_nb')->nullable();
            $table->json('nilai_kompeten_nc')->nullable();
            $table->json('nilai_kompeten_nd')->nullable();
            $table->json('nilai_kompeten_ne')->nullable();
            $table->json('nilai_kompeten_ns')->nullable();
            $table->json('nilai_kompeten_nf')->nullable();
            $table->json('nilai_kompeten_ng')->nullable();
            $table->json('nilai_kompeten_na')->nullable();
            $table->json('nilai_kompeten_nv')->nullable();
            $table->decimal('nilai_nb', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_nc', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_nd', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_ne', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_ns', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_nf', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_ng', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_na', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_nv', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai', $precision = 8, $scale = 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
