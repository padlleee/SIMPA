<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Alter peminjaman_buku
        Schema::table('peminjaman_buku', function (Blueprint $table) {
            // Ubah tipe peminjam
            $table->enum('tipe_peminjam', ['Anak Asuh', 'Donatur', 'Umum'])->default('Umum')->after('id_buku');
            
            // Kolom FK (id_anak is bigint in anak_asuh, id_donatur is bigint in donatur)
            $table->unsignedBigInteger('id_anak_asuh')->nullable()->after('tipe_peminjam');
            $table->unsignedBigInteger('id_donatur')->nullable()->after('id_anak_asuh');
            
            // Foreign keys
            $table->foreign('id_anak_asuh')->references('id_anak')->on('anak_asuh')->onDelete('set null');
            $table->foreign('id_donatur')->references('id_donatur')->on('donatur')->onDelete('set null');
        });

        // 2. Make nama_peminjam nullable using raw SQL to avoid doctrine/dbal requirement
        DB::statement('ALTER TABLE peminjaman_buku MODIFY nama_peminjam VARCHAR(100) NULL');

        // 2. Drop peminjaman_buku_donatur
        Schema::dropIfExists('peminjaman_buku_donatur');
    }

    public function down(): void
    {
        // Recreate peminjaman_buku_donatur (basic structure)
        Schema::create('peminjaman_buku_donatur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('donatur_id');
            $table->unsignedInteger('buku_id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->unsignedInteger('dana_jaminan')->default(0);
            $table->enum('status', ['Pending', 'Dipinjam', 'Kembali', 'Dana Hangus'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::table('peminjaman_buku', function (Blueprint $table) {
            $table->dropForeign(['id_anak_asuh']);
            $table->dropForeign(['id_donatur']);
            $table->dropColumn(['tipe_peminjam', 'id_anak_asuh', 'id_donatur']);
        });
        
        DB::statement('ALTER TABLE peminjaman_buku MODIFY nama_peminjam VARCHAR(100) NOT NULL');
    }
};
