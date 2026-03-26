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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('nomor_whatsapp');
            $table->string('paket');
            $table->string('jenis_layanan');
            $table->double('berat')->nullable();
            $table->integer('jumlah_item')->nullable();
            $table->integer('total_estimasi_harga');
            $table->string('metode_pembayaran');
            $table->string('metode_pengiriman');
            $table->string('jam_pickup')->nullable();
            $table->decimal('pickup_lat', 11, 8)->nullable();
            $table->decimal('pickup_lng', 11, 8)->nullable();
            $table->text('detail_alamat')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
