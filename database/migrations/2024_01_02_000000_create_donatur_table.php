<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create donatur table - stores donor information with optional user link
     */
    public function up(): void
    {
        Schema::create('donatur', function (Blueprint $table) {
            // Primary key
            $table->bigIncrements('id_donatur');

            // Foreign key to users table (nullable for anonymous donations)
            $table->unsignedBigInteger('id_user')->nullable();

            // Donor information
            $table->string('nama_donatur', 150);
            $table->string('email', 120)->unique();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();

            // Timestamps
            $table->timestamp('created_at')->useCurrent();

            // Foreign key constraint
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donatur');
    }
};
