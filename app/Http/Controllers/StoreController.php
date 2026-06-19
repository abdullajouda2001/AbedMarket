<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
 public function index()
{
    // جلب البيانات من قاعدة البيانات
   $categories = \App\Models\Category::all();
    $sidebarCategories = \App\Models\Category::all(); 
    $bestSellers = \App\Models\Product::limit(5)->get(); // جلب أول 5 منتجات بدون شروط إضافية
    $products = \App\Models\Product::all(); 

    return view('store.home', compact( 'categories', 'sidebarCategories', 'bestSellers', 'products'));
}
}