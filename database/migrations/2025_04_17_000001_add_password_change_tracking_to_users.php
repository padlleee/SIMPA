<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * NOTE: These columns are now part of the main users table creation.
     * This migration is kept for backward compatibility with existing databases.
     */
    public function up(): void
    {
        // Only add columns if they don't already exist (for existing databases)
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Check and add columns only if missing
                if (!Schema::hasColumn('users', 'force_password_change')) {
                    $table->boolean('force_password_change')->default(true)->comment('Set to true for new accounts');
                }

                if (!Schema::hasColumn('users', 'password_changed_at')) {
                    $table->timestamp('password_changed_at')->nullable()->comment('When password was last changed');
                }

                if (!Schema::hasColumn('users', 'status')) {
                    $table->enum('status', ['active', 'inactive'])->default('active');
                }
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'force_password_change')) {
                    $table->dropColumn('force_password_change');
                }
                if (Schema::hasColumn('users', 'password_changed_at')) {
                    $table->dropColumn('password_changed_at');
                }
                if (Schema::hasColumn('users', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
