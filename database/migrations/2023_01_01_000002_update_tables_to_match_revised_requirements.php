<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: These columns are now part of main table creation migrations.
     * This migration is kept only for backward compatibility with existing databases.
     */
    public function up(): void
    {
        // Alter Anak Asuh - Only if table exists and columns don't
        if (Schema::hasTable('anak_asuh')) {
            Schema::table('anak_asuh', function (Blueprint $table) {
                if (!Schema::hasColumn('anak_asuh', 'jenis_layanan')) {
                    $table->string('jenis_layanan', 100)->nullable()->after('jenis_kelamin');
                }
                if (!Schema::hasColumn('anak_asuh', 'dusun')) {
                    $table->string('dusun', 100)->nullable()->after('jenis_layanan');
                }
                if (!Schema::hasColumn('anak_asuh', 'rt')) {
                    $table->string('rt', 10)->nullable()->after('dusun');
                }
                if (!Schema::hasColumn('anak_asuh', 'rw')) {
                    $table->string('rw', 10)->nullable()->after('rt');
                }
                if (!Schema::hasColumn('anak_asuh', 'desa')) {
                    $table->string('desa', 100)->nullable()->after('rw');
                }
                if (!Schema::hasColumn('anak_asuh', 'kecamatan')) {
                    $table->string('kecamatan', 100)->nullable()->after('desa');
                }
            });
        }

        // Alter Stok Panti - Only if needed
        if (Schema::hasTable('stok_panti')) {
            Schema::table('stok_panti', function (Blueprint $table) {
                // Drop old column if exists
                if (Schema::hasColumn('stok_panti', 'jumlah')) {
                    $table->dropColumn('jumlah');
                }
                // Add new columns if missing
                if (!Schema::hasColumn('stok_panti', 'stok_awal')) {
                    $table->integer('stok_awal')->default(0)->after('kategori_barang');
                }
                if (!Schema::hasColumn('stok_panti', 'barang_masuk')) {
                    $table->integer('barang_masuk')->default(0)->after('stok_awal');
                }
                if (!Schema::hasColumn('stok_panti', 'barang_keluar')) {
                    $table->integer('barang_keluar')->default(0)->after('barang_masuk');
                }
                if (!Schema::hasColumn('stok_panti', 'stok_akhir')) {
                    $table->integer('stok_akhir')->default(0)->after('barang_keluar');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('anak_asuh')) {
            Schema::table('anak_asuh', function (Blueprint $table) {
                $columns = ['jenis_layanan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('anak_asuh', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('stok_panti')) {
            Schema::table('stok_panti', function (Blueprint $table) {
                $columns = ['stok_awal', 'barang_masuk', 'barang_keluar', 'stok_akhir'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('stok_panti', $col)) {
                        $table->dropColumn($col);
                    }
                }
                if (!Schema::hasColumn('stok_panti', 'jumlah')) {
                    $table->integer('jumlah')->default(0)->after('kategori_barang');
                }
            });
        }
    }
};
