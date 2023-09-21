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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan')->nullable();
            $table->string('nama');
            $table->string('username');
            $table->tinyInteger('role');
            $table->string('jenis_plp')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('jenis_plp');
            $table->bigInteger('id_dpl')->nullable();
            $table->bigInteger('id_guru_pamong')->nullable();
            $table->bigInteger('id_mahasiswa')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
