<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengurus_non_aktifs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan_terakhir')->nullable();
            $table->string('tahun_nonaktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengurus_non_aktifs');
    }
};
