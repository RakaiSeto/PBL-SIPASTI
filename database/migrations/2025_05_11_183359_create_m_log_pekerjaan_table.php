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
        Schema::create('m_log_pekerjaan', function (Blueprint $table) {
            $table->id('log_pekerjaan_id');
            $table->foreignId('laporan_id')->references('laporan_id')->on('m_laporan');
            $table->string('deskripsi_pekerjaan');
            $table->datetime('log_datetime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_log_pekerjaan');
    }
};
