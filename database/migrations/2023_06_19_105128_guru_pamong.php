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
        Schema::create('guru_pamong', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('asal');
            $table->string('asal_sekolah');
            $table->bigInteger('id_dpl')->unique()->nullable();
            $table->bigInteger('id_mahasiswa')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_pamong');
    }
};
