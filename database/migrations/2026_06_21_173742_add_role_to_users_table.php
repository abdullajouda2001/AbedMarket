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
    Schema::table('users', function (Blueprint $table) {
        // إنشاء العمود مع تحديد القيمة الافتراضية 'customer'
        $table->string('role')->default('customer')->after('email'); 
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // حذف العمود في حال التراجع عن الـ Migration
        $table->dropColumn('role');
    });
}};
