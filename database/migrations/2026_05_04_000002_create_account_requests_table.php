<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create account_requests table for public donor account registration requests.
     */
    public function up(): void
    {
        if (!Schema::hasTable('account_requests')) {
            Schema::create('account_requests', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nama_lengkap', 150);
                $table->string('email', 150)->unique();
                $table->string('no_hp', 20)->nullable();
                $table->text('pesan')->nullable()->comment('Alasan ingin menjadi donatur');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->unsignedBigInteger('reviewed_by')->nullable();
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamps();

                $table->foreign('reviewed_by')->references('id_user')->on('users')->nullOnDelete();
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('account_requests');
    }
};
