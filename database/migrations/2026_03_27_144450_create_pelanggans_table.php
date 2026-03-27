<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // Nomor WA kita buat unik biar nggak ada data pelanggan kembar
            $table->string('nomor_whatsapp')->unique(); 
            $table->string('pickup_lat')->nullable();
            $table->string('pickup_lng')->nullable();
            $table->text('detail_alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};