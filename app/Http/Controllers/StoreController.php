<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * عرض الصفحة الرئيسية
     */
    public function index()
    {
        $sidebarCategories = Category::all();
        $categories = Category::withCount('products')->get();
        $bestSellers = Product::limit(5)->get();
        $products = Product::all();

        return view('store.home', compact('categories', 'sidebarCategories', 'bestSellers', 'products'));
    }

    /**
     * عرض منتج واحد فقط (مسار: /product/{id})
     */
    // لعرض تفاصيل منتج واحد فقط (صفحة جديدة)
public function show($id)
{
    $product = \App\Models\Product::findOrFail($id);
    $sidebarCategories = \App\Models\Category::all(); 

    // سنستخدم ملف جديد خاص بالمنتج فقط
    return view('store.product-details', compact('product', 'sidebarCategories'));
}

// لعرض منتجات قسم معين
public function showCategoryProducts($id)
{
    $category = \App\Models\Category::with('products')->findOrFail($id);
    $sidebarCategories = \App\Models\Category::all(); 

    // هذا الملف هو الذي يعرض "قائمة المنتجات" الخاص بالقسم
    return view('store.show', compact('category', 'sidebarCategories'));
}
    /**
     * البحث عن المنتجات
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $sidebarCategories = Category::all();
        $categories = Category::all();

        $products = Product::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

        return view('store.home', compact('products', 'query', 'categories', 'sidebarCategories'));
    }
}