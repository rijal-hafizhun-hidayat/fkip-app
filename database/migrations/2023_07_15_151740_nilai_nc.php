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
        Schema::create('nilai_nc', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_mahasiswa')->nullable();
            $table->json('nilai_kompeten')->nullable();
            $table->decimal('nilai', $precision = 8, $scale = 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_nc');
    }
};
