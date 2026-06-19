<?php

namespace App\Models;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    // الحقول المسموح بتعبئتها
    protected $fillable = [
        'category_id', 
        'name', 
        'price', 
        'stock', 
        'description', 
        'image'
    ];

    /**
     * المنتج ينتمي إلى قسم واحد
     */
    // أضف هذه الدالة داخل Product.php إذا أردت حساب نسبة الخصم
public function getDiscountPercentageAttribute(): ?int
{
    if ($this->offer && $this->offer->isActive()) {
        return (int) (($this->price - $this->offer->discount_price) / $this->price * 100);
    }
    return null;
}
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * المنتج قد يمتلك عرضاً واحداً (أو لا)
     */
    public function offer(): HasOne
    {
        return $this->hasOne(Offer::class);
    }

    /**
     * منطق السعر الذكي (Accessor)
     * سيقوم تلقائياً بإرجاع سعر العرض إذا كان موجوداً وسارياً
     */
    public function getFinalPriceAttribute(): float
    {
        if ($this->offer && ($this->offer->expires_at === null || $this->offer->expires_at > now())) {
            return (float) $this->offer->discount_price;
        }

        return (float) $this->price;
    }

    /**
     * التحقق هل المنتج عليه خصم حالياً؟
     */
    public function hasActiveOffer(): bool
    {
        return $this->offer()->where(function ($query) {
            $query->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
        })->exists();
    }
}