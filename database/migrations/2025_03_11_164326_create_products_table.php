<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->foreignId('category_id');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('model');
            $table->boolean('on_offer')->default(false);
            $table->decimal('discount')->default(0);
            $table->boolean('featured')->default(false);
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->integer('points')->default(0);
            $table->string('image')->default('https://res.cloudinary.com/dlmbw4who/image/upload/v1743097241/product-placeholder_jcgqx4.png');
            $table->boolean('deleted')->default(false);
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
