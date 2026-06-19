<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // الربط بجدول المنتجات
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // بيانات العرض
            $table->decimal('discount_price', 8, 2); // السعر بعد الخصم
            $table->timestamp('expires_at')->nullable(); // تاريخ انتهاء العرض
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};