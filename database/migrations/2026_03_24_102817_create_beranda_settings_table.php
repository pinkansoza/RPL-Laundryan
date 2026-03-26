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
        Schema::create('beranda_settings', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('slogan');  // Kita pakai nama 'slogan'
            $table->string('gambar')->nullable(); // Kita pakai nama 'gambar'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beranda_settings');
    }
};
