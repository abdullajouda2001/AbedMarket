<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = [
    'user_id', 'phone', 'address', 'current_balance',
];
public function user()
{
    return $this->belongsTo(User::class);
}
public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_profile_id');
    }
    // في app/Models/CustomerProfile.php
public function payments()
{
    return $this->hasMany(Payment::class, 'customer_profile_id');
}
}

