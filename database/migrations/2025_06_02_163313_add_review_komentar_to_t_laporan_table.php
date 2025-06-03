<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('t_laporan', function (Blueprint $table) {
            $table->text('review_komentar')->nullable()->after('review_pelapor');
        });
    }

    public function down()
    {
        Schema::table('t_laporan', function (Blueprint $table) {
            $table->dropColumn('review_komentar');
        });
    }
};
