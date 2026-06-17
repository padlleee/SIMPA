<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration 3: Add 'kode_unik_aset' and 'ruangan' to inventaris_peralatan.
 *
 * Shifts from quantity-based tracking to unique per-asset tracking.
 * Each physical asset now gets its own record with a unique asset code
 * and room assignment for location filtering.
 *
 * NOTE: Existing 'kode_barang' is a product-type code (e.g., "CHAIR-001").
 *       'kode_unik_aset' is the individual unit tag (e.g., "CHAIR-001/A/001").
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris_peralatan', function (Blueprint $table) {
            if (!Schema::hasColumn('inventaris_peralatan', 'kode_unik_aset')) {
                $table->string('kode_unik_aset', 100)->nullable()->unique()
                      ->after('kode_barang')
                      ->comment('Unique per-unit asset tag for individual tracking');
            }

            if (!Schema::hasColumn('inventaris_peralatan', 'ruangan')) {
                $table->enum('ruangan', [
                    'Kantor',
                    'Asrama',
                    'Dapur',
                    'Aula',
                    'Perpustakaan',
                    'Ruang Belajar',
                    'Gudang',
                    'Lainnya',
                ])->nullable()->after('lokasi')
                  ->comment('Room/area where the asset is located for filtering');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventaris_peralatan', function (Blueprint $table) {
            $table->dropColumn(['kode_unik_aset', 'ruangan']);
        });
    }
};
