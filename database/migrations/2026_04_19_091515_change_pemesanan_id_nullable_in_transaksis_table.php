<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['pemesanan_id']);
            $table->unsignedBigInteger('pemesanan_id')->nullable()->change();
            $table->foreign('pemesanan_id')
                ->references('id')->on('pemesanans')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['pemesanan_id']);
            $table->unsignedBigInteger('pemesanan_id')->nullable(false)->change();
            $table->foreign('pemesanan_id')
                ->references('id')->on('pemesanans')
                ->onDelete('cascade');
        });
    }
};
