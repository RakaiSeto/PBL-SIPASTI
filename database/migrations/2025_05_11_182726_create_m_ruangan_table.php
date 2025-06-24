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
        Schema::create('m_ruangan', function (Blueprint $table) {
            $table->id('ruangan_id');
            $table->foreignId('ruangan_role_id')->references('ruangan_role_id')->on('m_ruangan_role');
            $table->string('ruangan_nama');
            $table->string('lantai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_ruangan');
    }
};
