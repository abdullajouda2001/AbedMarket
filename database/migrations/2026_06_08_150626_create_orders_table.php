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
$table->decimal('total_price', 8, 2);
$table->decimal('delivery_fee', 8, 2);
$table->decimal('bonus_amount', 8, 2); // بونص التوصيل
$table->string('status')->default('pending'); // pending, delivering, completed
$table->decimal('latitude', 10, 8)->nullable(); // للموقع
$table->decimal('longitude', 11, 8)->nullable();
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
