<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    // protected $fillable = ['customer_profile_id', 'total_amount', 'notes'];
protected $fillable = ['invoice_id', 'product_name', 'quantity', 'price'];
    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }

    public function customer() {
        return $this->belongsTo(CustomerProfile::class, 'customer_profile_id');
    }
}
