<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perpustakaan', function (Blueprint $table) {
            $table->string('penulis', 150)->nullable()->after('pengarang');       // alias/full author name
            $table->string('penerbit', 150)->nullable()->after('penulis');        // publisher
            $table->year('tahun_terbit')->nullable()->after('penerbit');          // year
            $table->string('isbn', 30)->nullable()->after('tahun_terbit');        // ISBN
            $table->string('kategori_buku', 80)->nullable()->after('isbn');       // genre/category
            $table->text('sinopsis')->nullable()->after('kategori_buku');         // synopsis
            $table->string('foto_buku')->nullable()->after('sinopsis');           // cover image path
        });
    }

    public function down(): void
    {
        Schema::table('perpustakaan', function (Blueprint $table) {
            $table->dropColumn(['penulis','penerbit','tahun_terbit','isbn','kategori_buku','sinopsis','foto_buku']);
        });
    }
};
