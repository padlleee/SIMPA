<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stok_panti', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('stok_akhir');
            $table->unsignedBigInteger('id_admin')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stok_panti', function (Blueprint $table) {
            $table->dropColumn(['keterangan', 'id_admin']);
        });
    }
};
