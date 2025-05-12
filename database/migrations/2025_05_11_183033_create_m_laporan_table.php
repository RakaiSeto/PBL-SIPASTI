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
        Schema::create('m_laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->foreignId('user_id')->references('user_id')->on('m_user');
            $table->foreignId('fasilitas_ruang_id')->references('fasilitas_ruang_id')->on('m_fasilitas_ruang');
            $table->foreignId('teknisi_id')->references('user_id')->on('m_user');
            $table->text('deskripsi_laporan');
            $table->datetime('lapor_datetime');
            $table->integer('review_pelapor');
            $table->boolean('is_verified');
            $table->boolean('is_done');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_laporan');
    }
};
