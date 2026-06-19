<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug','image'];
public function items()
    {
        // إذا كان عندك مودل للمنتجات (Product)، استخدم hasMany
        return $this->hasMany(Product::class); 
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected static function booted()
    {
        static::creating(function ($category) {
            // تحويل الاسم لـ Slug تلقائياً
            $category->slug = Str::slug($category->name);
        });
    }
}