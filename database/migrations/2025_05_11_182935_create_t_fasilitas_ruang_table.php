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
        Schema::create('t_fasilitas_ruang', function (Blueprint $table) {
            $table->id('fasilitas_ruang_id');
            $table->foreignId('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas');
            $table->foreignId('ruangan_id')->references('ruangan_id')->on('m_ruangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_fasilitas_ruang');
    }
};
