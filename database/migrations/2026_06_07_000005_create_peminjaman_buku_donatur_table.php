<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration 5: Create 'peminjaman_buku_donatur' table.
 *
 * Separate from the existing 'peminjaman_buku' (which is for orphan/internal lending),
 * this table handles book loans issued to registered Donatur who provide a security deposit.
 *
 * Status lifecycle:
 *   Pending → Dipinjam → Kembali
 *                     ↘ Dana Hangus  (if unreturned after deadline & donor forfeits deposit)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_buku_donatur', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('donatur_id');
            $table->unsignedInteger('buku_id');   // matches perpustakaan.id_buku (int unsigned)

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->comment('Expected return date');
            $table->date('tanggal_dikembalikan')->nullable()
                  ->comment('Actual return date; null until book is returned');

            // Security deposit (dana jaminan) in IDR
            $table->unsignedInteger('dana_jaminan')->default(0)
                  ->comment('Security deposit amount in IDR; forfeit on "Dana Hangus"');

            $table->enum('status', ['Pending', 'Dipinjam', 'Kembali', 'Dana Hangus'])
                  ->default('Pending');

            // Optional notes (e.g., condition on return, reason for forfeiture)
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('donatur_id');
            $table->index('status');

            $table->foreign('donatur_id')
                  ->references('id_donatur')
                  ->on('donatur')
                  ->onDelete('cascade');

            $table->foreign('buku_id')
                  ->references('id_buku')
                  ->on('perpustakaan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_buku_donatur');
    }
};
