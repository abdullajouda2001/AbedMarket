<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
    $cart = session()->get('cart', []);
    $sidebarCategories = \App\Models\Category::all();
    return view('store.cart', compact('cart', 'sidebarCategories'));
}

public function remove($id) {
    $cart = session()->get('cart');
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return back()->with('success', 'تم حذف المنتج من السلة');
}
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // إذا كان المنتج موجوداً، زد الكمية
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            // إضافة منتج جديد
            $cart[$request->product_id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'تمت إضافة المنتج للسلة بنجاح!');
    }
}
