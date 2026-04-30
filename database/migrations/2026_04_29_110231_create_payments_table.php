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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->cascadeOnDelete();
        $table->enum('gateway', ['paystack', 'stripe'])->default('paystack');
        $table->string('gateway_reference')->nullable();
        $table->json('gateway_response')->nullable();
        $table->decimal('amount', 10, 2);
        $table->string('currency')->default('NGN');
        $table->enum('status', ['pending','paid','failed','refunded'])->default('pending');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
