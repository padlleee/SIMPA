<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration 4: Create 'kas_masuk' table for income/cash-in ledger.
 *
 * This replaces a single-category "laporan" concept with a flexible
 * income ledger that supports multiple non-donation cash sources such as:
 * - Donasi (linked to donasi table)
 * - Penjualan Hasil Karya (product sales)
 * - Dana Hibah (grants)
 * - Subsidi Pemerintah (government subsidies)
 * - Lainnya (other income)
 *
 * Design Decision:
 * - 'sumber_dana' uses an enum for controlled vocabulary but includes 'Lainnya'
 *   for extensibility. If more categories are needed in the future, add a
 *   migration to extend the enum.
 * - 'id_referensi' links optionally to the donasi table when sumber_dana = 'Donasi'.
 * - 'keterangan' is free-text for any source requiring additional description.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_masuk', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('sumber_dana', [
                'Donasi',
                'Penjualan Hasil Karya',
                'Dana Hibah',
                'Subsidi Pemerintah',
                'Infaq/Sedekah',
                'Lainnya',
            ])->default('Donasi');

            // Optional FK to donasi table — set when sumber_dana = 'Donasi'
            $table->unsignedBigInteger('id_referensi_donasi')->nullable()
                  ->comment('FK to donasi.id_donasi; only set when sumber_dana = Donasi');

            $table->date('tanggal');
            $table->unsignedBigInteger('jumlah')->comment('Amount in IDR (no decimal)');
            $table->text('keterangan')->nullable()
                  ->comment('Required when sumber_dana = Lainnya; optional otherwise');

            // Admin who recorded this entry
            $table->unsignedBigInteger('dicatat_oleh')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('sumber_dana');
            $table->index('tanggal');

            $table->foreign('id_referensi_donasi')
                  ->references('id_donasi')
                  ->on('donasi')
                  ->onDelete('set null');

            $table->foreign('dicatat_oleh')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_masuk');
    }
};
