<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create donasi table - stores all donation records with status tracking
     */
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            // Primary key
            $table->bigIncrements('id_donasi');

            // Donor information (can be from registered users or manual entry)
            $table->unsignedBigInteger('id_donatur')->nullable();
            $table->string('nama_donatur_manual', 150)->nullable()->comment('For public donations');
            $table->string('email_donatur_manual', 120)->nullable()->comment('Email for public donations');

            // Donation details
            $table->decimal('nominal', 15, 2);
            $table->enum('metode_pembayaran', ['Transfer', 'QRIS', 'Tunai', 'BJB', 'BRI'])->default('Transfer');
            $table->string('bukti_pembayaran')->nullable()->comment('File path to proof of transfer');

            // Status workflow: Pending → Valid (approved) or Tolak (rejected)
            $table->enum('status_verifikasi', ['Pending', 'Valid', 'Tolak'])->default('Pending');

            // Admin verification
            $table->unsignedBigInteger('id_bendahara')->nullable()->comment('User who verified donation');
            $table->text('catatan_verifikasi')->nullable();

            // Timestamps
            $table->timestamp('tanggal_donasi')->useCurrent();
            $table->timestamp('tanggal_verifikasi')->nullable();

            // Foreign key constraints
            $table->foreign('id_donatur')->references('id_user')->on('users')->onDelete('set null');
            $table->foreign('id_bendahara')->references('id_user')->on('users')->onDelete('set null');

            // Indexes for efficient queries
            $table->index('status_verifikasi');
            $table->index('tanggal_donasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
