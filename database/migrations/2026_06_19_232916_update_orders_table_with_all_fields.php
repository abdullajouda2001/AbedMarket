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
    Schema::table('orders', function (Blueprint $table) {
        // نستخدم Schema::hasColumn للتأكد من عدم وجود تكرار
        if (!Schema::hasColumn('orders', 'customer_name')) $table->string('customer_name')->nullable();
        if (!Schema::hasColumn('orders', 'customer_phone')) $table->string('customer_phone')->nullable();
        if (!Schema::hasColumn('orders', 'address')) $table->string('address')->nullable();
        if (!Schema::hasColumn('orders', 'subtotal')) $table->decimal('subtotal', 8, 2);
        if (!Schema::hasColumn('orders', 'delivery_fee')) $table->decimal('delivery_fee', 8, 2);
        if (!Schema::hasColumn('orders', 'total_price')) $table->decimal('total_price', 8, 2);
        if (!Schema::hasColumn('orders', 'payment_status')) $table->string('payment_status')->default('unpaid');
    });
}
    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn([
            'customer_name', 
            'customer_phone', 
            'address', 
            'subtotal', 
            'delivery_fee', 
            'total_price', 
            'payment_status'
        ]);
    });
}};
