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
        if (!Schema::hasTable('pengeluaran')) {
            Schema::create('pengeluaran', function (Blueprint $table) {
                $table->integer('id_pengeluaran')->autoIncrement();
                $table->string('kategori_biaya', 50)->nullable();
                $table->text('keterangan')->nullable();
                $table->decimal('nominal', 15, 2);
                $table->date('tanggal_pengeluaran');
                $table->unsignedBigInteger('id_bendahara')->nullable();
                $table->foreign('id_bendahara')->references('id_user')->on('users');
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluaran');
    }
};
