<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: Modify ENUM to add 'Sembako / Barang' without losing data
        DB::statement("ALTER TABLE donasi MODIFY COLUMN metode_pembayaran ENUM('Transfer','QRIS','Tunai','BJB','BRI','Sembako / Barang') NOT NULL DEFAULT 'Transfer'");
    }

    public function down(): void
    {
        // Revert: remove 'Sembako / Barang' (rows with this value must be deleted first)
        DB::statement("ALTER TABLE donasi MODIFY COLUMN metode_pembayaran ENUM('Transfer','QRIS','Tunai','BJB','BRI') NOT NULL DEFAULT 'Transfer'");
    }
};
