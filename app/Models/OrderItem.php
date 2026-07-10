<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // تحديد الجدول إذا كان اسم الموديل لا يطابق اسم الجدول (في حالتك هو يطابق، لكن هذا للتأكيد)
    protected $table = 'order_items';

    // السماح بهذه الحقول للإسناد الجماعي (Mass Assignment)
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * العلاقة: كل عنصر في الطلب ينتمي إلى طلب واحد
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * العلاقة: كل عنصر في الطلب يمثل منتجاً واحداً
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}