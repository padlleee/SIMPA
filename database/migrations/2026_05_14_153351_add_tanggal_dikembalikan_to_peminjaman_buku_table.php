<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman_buku', function (Blueprint $table) {
            // Actual date the book was returned (may differ from tanggal_kembali deadline)
            $table->date('tanggal_dikembalikan')->nullable()->after('tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman_buku', function (Blueprint $table) {
            $table->dropColumn('tanggal_dikembalikan');
        });
    }
};
