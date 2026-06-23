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
    public function up(): void
    {
        Schema::create('peminjaman_buku_donatur', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('donatur_id');
            $table->unsignedInteger('buku_id');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->comment('Expected return date');
            $table->date('tanggal_dikembalikan')->nullable()->comment('Actual return date');

            $table->unsignedInteger('dana_jaminan')->default(0)->comment('Security deposit');

            $table->enum('status', ['Pending', 'Dipinjam', 'Kembali', 'Dana Hangus'])->default('Pending');

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index('donatur_id');
            $table->index('status');

            $table->foreign('donatur_id')->references('id_donatur')->on('donatur')->onDelete('cascade');
            $table->foreign('buku_id')->references('id_buku')->on('perpustakaan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_buku_donatur');
    }
};
