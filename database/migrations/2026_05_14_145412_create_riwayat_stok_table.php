<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_stok', function (Blueprint $table) {
            $table->bigIncrements('id_riwayat');
            $table->unsignedBigInteger('id_stok')->nullable(); // FK to stok_panti
            $table->string('nama_barang', 150);                // denormalized for display
            $table->string('kategori_barang', 100)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->enum('jenis', ['Masuk', 'Keluar']);        // direction
            $table->integer('jumlah');                          // qty moved
            $table->integer('stok_sebelum')->default(0);        // stock before
            $table->integer('stok_sesudah')->default(0);        // stock after
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable(); // who recorded
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_stok');
    }
};
