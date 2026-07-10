<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::table('orders', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->change();
        $table->string('customer_name')->nullable();
        $table->string('customer_phone')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        // 1. إعادة العمود إلى حالته الأصلية (إجباري وليس nullable)
        // ملاحظة: قد تحتاج لإضافة ->change() هنا إذا كنت تستخدم MySQL
        $table->unsignedBigInteger('user_id')->nullable(false)->change();
        
        // 2. حذف الأعمدة التي قمت بإضافتها
        $table->dropColumn(['customer_name', 'customer_phone']);
    });
}
};
