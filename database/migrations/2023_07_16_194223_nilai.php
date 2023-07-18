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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_mahasiswa')->nullable();
            $table->string('jenis_plp');
            $table->json('nilai_kompeten_nb')->nullable();
            $table->json('nilai_kompeten_nc')->nullable();
            $table->json('nilai_kompeten_nd')->nullable();
            $table->decimal('nilai_nb', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_nc', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai_nd', $precision = 8, $scale = 1)->nullable();
            $table->decimal('nilai', $precision = 8, $scale = 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
