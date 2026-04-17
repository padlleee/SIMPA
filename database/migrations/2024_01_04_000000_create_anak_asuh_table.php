<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create anak_asuh table - stores orphan/foster child information
     * NOTE: This may already exist from 2022_01_01_000000_create_anak_asuh_table.php
     * This version is kept for compatibility.
     */
    public function up(): void
    {
        if (!Schema::hasTable('anak_asuh')) {
            Schema::create('anak_asuh', function (Blueprint $table) {
                // Primary key
                $table->bigIncrements('id_anak');

                // Personal information
                $table->string('nama_anak', 150);
                $table->string('tempat_lahir', 100)->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->comment('L: Laki-laki, P: Perempuan');

                // Service & address
                $table->string('jenis_layanan', 100)->nullable();
                $table->string('dusun', 100)->nullable();
                $table->string('rt', 10)->nullable();
                $table->string('rw', 10)->nullable();
                $table->string('desa', 100)->nullable();
                $table->string('kecamatan', 100)->nullable();

                // Status tracking
                $table->enum('status_anak', ['Aktif', 'Alumni'])->default('Aktif');
                $table->date('tanggal_masuk')->nullable();

                // Health & academic notes
                $table->text('catatan_kesehatan')->nullable();
                $table->text('perkembangan_akademik')->nullable();

                // Timestamps
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_asuh');
    }
};
