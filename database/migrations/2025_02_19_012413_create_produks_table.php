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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade'); // Foreign key ke tabel kategori
            $table->string('nama');
            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
