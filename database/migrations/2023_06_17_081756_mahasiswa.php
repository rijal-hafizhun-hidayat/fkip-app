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
            $table->bigInteger('nim')->unique();
            $table->bigInteger('id_guru_pamong')->nullable();
            $table->string('nama');
            $table->string('email');
            $table->string('prodi');
            $table->integer('n_komponen_satu')->nullable();
            $table->integer('n_komponen_dua')->nullable();
            $table->integer('n_komponen_tiga')->nullable();
            $table->integer('n_komponen_empat')->nullable();
            $table->integer('n_komponen_lima')->nullable();
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
