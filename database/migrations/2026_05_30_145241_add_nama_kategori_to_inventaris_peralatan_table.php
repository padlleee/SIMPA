<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventaris_peralatan', function (Blueprint $table) {
            // Kolom kategori untuk pengelompokan (contoh: "Kulkas", "Kipas Angin")
            $table->string('nama_kategori')->nullable()->after('nama_barang');
        });

        // Isi nama_kategori dengan nilai nama_barang yang ada (backward compat)
        \DB::statement("UPDATE inventaris_peralatan SET nama_kategori = nama_barang WHERE nama_kategori IS NULL");
    }

    public function down()
    {
        Schema::table('inventaris_peralatan', function (Blueprint $table) {
            $table->dropColumn('nama_kategori');
        });
    }
};
