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
        Schema::create('hargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket'); // Contoh: REGULER
            $table->string('estimasi');   // Contoh: 2-3 Hari Pengerjaan
            $table->json('konten');       // TEMPAT REPEATER (Kategori & Item)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hargas');
    }
};
