<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary Key with id_ prefix to match SIMPA schema
            $table->bigIncrements('id_user');

            // Core authentication
            $table->string('username', 100)->unique();
            $table->string('password');

            // User role: Admin, Ketua, Donatur, Bendahara
            $table->enum('role', ['Admin', 'Ketua', 'Donatur', 'Bendahara'])->default('Donatur');

            // Optional access code for audit trail
            $table->string('kode_akses', 50)->nullable();

            // Account security & status
            $table->boolean('force_password_change')->default(true)->comment('Forces password change on first login');
            $table->timestamp('last_login_at')->nullable()->comment('When user last logged in');
            $table->timestamp('password_changed_at')->nullable()->comment('When password was last changed');
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Timestamps
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
