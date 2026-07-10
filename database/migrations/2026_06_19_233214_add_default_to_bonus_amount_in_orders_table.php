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
        // تغيير العمود ليكون له قيمة افتراضية 0
        $table->decimal('bonus_amount', 8, 2)->default(0)->change();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        // نقوم بإزالة القيمة الافتراضية وإعادة العمود كما كان
        // إذا كان العمود يقبل NULL سابقاً، أضف ->nullable()
        $table->decimal('bonus_amount', 8, 2)->default(null)->change();
    });
}
};
