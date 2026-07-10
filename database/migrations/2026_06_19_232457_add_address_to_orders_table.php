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
        // إضافة عمود العنوان إذا لم يكن موجوداً
        if (!Schema::hasColumn('orders', 'address')) {
            $table->string('address')->after('status');
        }
        
        // إضافة عمود حالة الدفع
        if (!Schema::hasColumn('orders', 'payment_status')) {
            $table->string('payment_status')->default('unpaid')->after('address');
        }
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['address', 'payment_status']);
    });
}
};
