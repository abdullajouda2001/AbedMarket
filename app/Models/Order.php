<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   // داخل ملف app/Models/Order.php
protected $fillable = [
    'user_id', 
    'customer_name', 
    'customer_phone', 
    'address',        // تأكد من وجود هذا
    'payment_status', // وتأكد من وجود هذا
    'subtotal', 
    'delivery_fee', 
    'total_price', 
    'status'
];
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
public function user() {
    return $this->belongsTo(User::class);
}
}

