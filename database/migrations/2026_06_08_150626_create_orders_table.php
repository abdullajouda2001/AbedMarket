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
        
        // نجعلها nullable ليتمكن الزائر من الطلب بدون حساب
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        
        // بيانات الزائر (مهمة جداً للطلبات بدون تسجيل)
        $table->string('customer_name')->nullable();
        $table->string('customer_phone')->nullable();
        
        $table->decimal('subtotal', 8, 2);
        $table->decimal('delivery_fee', 8, 2);
        $table->decimal('bonus_amount', 8, 2)->default(0);
        $table->decimal('total_price', 8, 2);
        $table->string('status')->default('pending');
        $table->string('payment_status')->default('unpaid');
        $table->string('address'); 
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
