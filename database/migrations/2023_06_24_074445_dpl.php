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
        Schema::create('dpl', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('nipy')->unique();
            $table->string('email');
            $table->string('prodi');
            $table->bigInteger('id_guru_pamong')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpl');
    }
};
