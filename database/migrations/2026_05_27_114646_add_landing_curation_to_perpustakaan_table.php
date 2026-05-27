<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add is_featured and kategori_landing columns to the perpustakaan table
     * to allow admin control over landing page book curation sections.
     */
    public function up(): void
    {
        Schema::table('perpustakaan', function (Blueprint $table) {
            // Toggle: show this book on the landing page curated section
            $table->boolean('is_featured')->default(false)->after('kondisi_buku');

            // Which landing section this book belongs to:
            // 'sering_dipinjam' | 'buku_baru' | 'buku_unik'
            $table->string('kategori_landing', 30)->nullable()->after('is_featured');

            // Index for fast filtering on landing page query
            $table->index(['is_featured', 'kategori_landing'], 'idx_landing_curation');
        });
    }

    public function down(): void
    {
        Schema::table('perpustakaan', function (Blueprint $table) {
            $table->dropIndex('idx_landing_curation');
            $table->dropColumn(['is_featured', 'kategori_landing']);
        });
    }
};
