<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Perpustakaan (book inventory)
        Schema::create('perpustakaan', function (Blueprint $table) {
            $table->increments('id_buku');
            $table->string('kode_buku', 20)->unique();
            $table->string('judul_buku', 200);
            $table->string('pengarang', 100);
            $table->integer('jumlah_buku')->default(1);
            $table->string('kondisi_buku', 50)->nullable()->default('Baik');
            $table->timestamps();
        });

        // Peminjaman Buku (book lending)
        Schema::create('peminjaman_buku', function (Blueprint $table) {
            $table->increments('id_pinjam');
            $table->unsignedInteger('id_buku');
            $table->string('nama_peminjam', 100);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->timestamps();

            $table->foreign('id_buku')->references('id_buku')->on('perpustakaan')->onDelete('cascade');
        });

        // Inventaris Peralatan (equipment assets)
        Schema::create('inventaris_peralatan', function (Blueprint $table) {
            $table->increments('id_aset');
            $table->string('nama_barang', 100);
            $table->integer('jumlah')->default(1);
            $table->string('satuan', 50)->nullable();
            $table->string('kode_barang', 50)->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak'])->default('Baik');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman_buku');
        Schema::dropIfExists('perpustakaan');
        Schema::dropIfExists('inventaris_peralatan');
    }
};
