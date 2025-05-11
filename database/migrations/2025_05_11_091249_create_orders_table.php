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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cart_id')->nullable()->constrained();
            $table->enum('status', [
                'pending_payment', 
                'paid', 
                'processing', 
                'shipped', 
                'delivered', 
                'cancelled', 
                'refunded'
            ])->default('pending_payment');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable(); // Paypal transaction ID or similar
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('EUR');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
