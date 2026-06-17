<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create 'prestasi_anak' table.
 *
 * Replaces the generic many-to-many labels system.
 * Each row is one free-text achievement badge belonging to a single child.
 * Examples:
 *   - "Naik Kelas – Semester 4"
 *   - "Juara 1 – Lomba Baca Tulis Qur'an"
 *   - "Peringkat 1 – SMP Kelas 7"
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi_anak', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('anak_asuh_id');

            // Free-text achievement label
            // e.g. "Juara 1 – Baca Tulis Qur'an" or "Naik Kelas Semester 6"
            $table->string('teks_prestasi', 200);

            // Optional: when the achievement was recorded
            $table->date('tanggal_dicatat')->nullable();

            // Optional color for the badge (#HEX), defaults to indigo-ish
            $table->string('warna_hex', 7)->default('#4f46e5');

            $table->timestamps();

            $table->index('anak_asuh_id');

            $table->foreign('anak_asuh_id')
                  ->references('id_anak')
                  ->on('anak_asuh')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi_anak');
    }
};
