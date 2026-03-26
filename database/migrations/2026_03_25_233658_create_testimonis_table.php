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
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->text('pesan');
            $table->integer('bintang')->default(5); // 1-5 bintang
            $table->string('foto_pelanggan')->nullable(); // Opsional
            $table->boolean('is_tampilkan')->default(true); // Biar bisa pilih mana yang mau dipublish
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
