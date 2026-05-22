<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calon_anak_asuh', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nama_wali');
            $table->string('kontak_wali', 20);
            $table->text('alasan_masuk');
            $table->string('dokumen_path')->nullable(); // path of uploaded PDF/ZIP in storage/app/public/pendaftaran/
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id_user')->on('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('catatan_review')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_anak_asuh');
    }
};
