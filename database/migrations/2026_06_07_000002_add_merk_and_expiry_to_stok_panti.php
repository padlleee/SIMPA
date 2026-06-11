<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration 2: Add 'merk' and 'tanggal_kadaluarsa' to stok_panti.
 *
 * NOTE: 'kode_barang' (string, unique) already exists in the original
 * 2022_01_02 migration as nullable. This migration ensures it becomes
 * non-nullable if data allows; but to be safe we only add missing columns.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stok_panti', function (Blueprint $table) {
            // Add merk (brand) — only if not already present
            if (!Schema::hasColumn('stok_panti', 'merk')) {
                $table->string('merk', 100)->nullable()->after('nama_barang')
                      ->comment('Brand/manufacturer of the item');
            }

            // Add expiry date — only if not already present
            if (!Schema::hasColumn('stok_panti', 'tanggal_kadaluarsa')) {
                $table->date('tanggal_kadaluarsa')->nullable()->after('satuan')
                      ->comment('Expiry date; null for non-perishable items');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stok_panti', function (Blueprint $table) {
            $table->dropColumn(['merk', 'tanggal_kadaluarsa']);
        });
    }
};
