<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration 1: Create 'labels' table and 'anak_asuh_label' pivot table.
 *
 * Labels are reusable badges (e.g., "Perlu Bimbingan Khusus", "Berprestasi")
 * that admin can attach dynamically to orphan records.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Master labels table
        Schema::create('labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_label', 100);
            $table->string('warna_hex', 7)->default('#6366f1')->comment('CSS hex color, e.g. #3b82f6');
            $table->timestamps();
        });

        // Pivot table: many-to-many between anak_asuh and labels
        Schema::create('anak_asuh_label', function (Blueprint $table) {
            $table->unsignedBigInteger('anak_asuh_id');
            $table->unsignedBigInteger('label_id');

            $table->primary(['anak_asuh_id', 'label_id']);

            $table->foreign('anak_asuh_id')
                  ->references('id_anak')
                  ->on('anak_asuh')
                  ->onDelete('cascade');

            $table->foreign('label_id')
                  ->references('id')
                  ->on('labels')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anak_asuh_label');
        Schema::dropIfExists('labels');
    }
};
