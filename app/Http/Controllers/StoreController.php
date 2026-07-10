<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $sidebarCategories = Category::all();
        $categories = Category::withCount('products')->get();
        $bestSellers = Product::limit(5)->get();
        $products = Product::all();

        return view('store.home', compact('categories', 'sidebarCategories', 'bestSellers', 'products'));
    }

    public function show($id)
    {
        // تم تعديل الاستدعاء هنا ليكون متوافقاً 100% مع السيرفر
        $product = Product::findOrFail($id); 
        $sidebarCategories = Category::all(); 

        return view('store.product-details', compact('product', 'sidebarCategories'));
    }

    public function showCategoryProducts($id)
    {
        // تم تعديل الاستدعاء هنا ليكون متوافقاً 100% مع السيرفر
        $category = Category::with('products')->findOrFail($id);
        $sidebarCategories = Category::all(); 

        return view('store.show', compact('category', 'sidebarCategories'));
    }

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