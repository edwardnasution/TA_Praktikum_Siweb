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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_product');

            // Menghubungkan ke tabel categories (kolom id)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Menghubungkan ke tabel brands (kolom brand_id)
            $table->foreignId('brand_id')->constrained('brands', 'brand_id')->onDelete('cascade');

            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
