<?php

namespace App\Models;

use App\Models\CustomerProfile;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = ['customer_profile_id', 'amount'];

    public function customer()
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_profile_id');
    }
}
