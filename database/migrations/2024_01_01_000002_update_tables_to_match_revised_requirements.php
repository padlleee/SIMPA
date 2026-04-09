<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Alter Anak Asuh
        Schema::table('anak_asuh', function (Blueprint $table) {
            $table->string('jenis_layanan', 100)->nullable()->after('jenis_kelamin');
            $table->string('dusun', 100)->nullable()->after('jenis_layanan');
            $table->string('rt', 10)->nullable()->after('dusun');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('desa', 100)->nullable()->after('rw');
            $table->string('kecamatan', 100)->nullable()->after('desa');
        });

        // Alter Stok Panti
        Schema::table('stok_panti', function (Blueprint $table) {
            $table->dropColumn('jumlah');
            $table->integer('stok_awal')->default(0)->after('kategori_barang');
            $table->integer('barang_masuk')->default(0)->after('stok_awal');
            $table->integer('barang_keluar')->default(0)->after('barang_masuk');
            $table->integer('stok_akhir')->default(0)->after('barang_keluar');
        });
    }

    public function down()
    {
        Schema::table('anak_asuh', function (Blueprint $table) {
            $table->dropColumn(['jenis_layanan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan']);
        });

        Schema::table('stok_panti', function (Blueprint $table) {
            $table->dropColumn(['stok_awal', 'barang_masuk', 'barang_keluar', 'stok_akhir']);
            $table->integer('jumlah')->default(0)->after('kategori_barang');
        });
    }
};
