<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create stok_panti table - warehouse inventory with mutation tracking
     * NOTE: This may already exist from 2022_01_02_000000_create_stok_panti_table.php
     * This version is kept for compatibility.
     */
    public function up(): void
    {
        if (!Schema::hasTable('stok_panti')) {
            Schema::create('stok_panti', function (Blueprint $table) {
                // Primary key
                $table->bigIncrements('id_stok');

                // Item information
                $table->string('nama_barang', 150);
                $table->string('kategori_barang', 100)->nullable();
                $table->string('satuan', 50)->nullable()->comment('Unit: Kg, Liter, Pcs, etc');
                $table->string('kode_barang', 50)->nullable()->unique();

                // Stock tracking - mutation log
                $table->integer('stok_awal')->default(0);
                $table->integer('barang_masuk')->default(0);
                $table->integer('barang_keluar')->default(0);
                $table->integer('stok_akhir')->default(0);

                // Minimum stock threshold for alerts
                $table->integer('stok_minimum')->default(0)->comment('Alert when below this level');

                // Storage location
                $table->string('lokasi', 100)->nullable();

                // Timestamps
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();

                // Index for efficient queries
                $table->index('kategori_barang');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_panti');
    }
};
