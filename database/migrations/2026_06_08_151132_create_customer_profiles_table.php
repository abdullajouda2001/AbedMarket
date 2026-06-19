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
       Schema::create('customer_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربطه بحساب الدخول
    $table->string('phone')->nullable(); // رقم الهاتف للديليفري
    $table->text('address')->nullable(); // العنوان الثابت
    $table->decimal('current_balance', 10, 2)->default(0.00); // الرصيد (موجب إذا له فلوس، سالب إذا عليه دين)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
