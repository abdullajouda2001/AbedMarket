<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::latest()->get();
    // أضفنا السطر التالي لجلب الأقسام
    $categories = \App\Models\Category::all(); 
    
    // أضفنا $categories إلى الـ compact
    return view('admin.products.index', compact('products', 'categories'));
}
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
{
    // زيادة القيد من 2048 إلى 5120 (5 ميجابايت)
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
    ]);

    if ($request->hasFile('image')) {
        // تخزين الصورة في مجلد 'products' داخل 'storage/app/public'
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($validated);
    
    return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');
}
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

public function update(Request $request, Product $product)
{
    // 1. التحقق من البيانات (تعديل 2048 إلى 5120)
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // تم التعديل هنا
    ]);

    // 2. معالجة الصورة
    if ($request->hasFile('image')) {
        // حذف الصورة القديمة
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        // حفظ الصورة الجديدة
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    } else {
        // نضع القيمة القديمة يدوياً إذا لم يتم رفع ملف جديد
        $validated['image'] = $product->image;
    }

    // 3. التحديث المباشر
    $product->update($validated);

    return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح');
}

public function search(Request $request)
{
    $term = $request->get('term');
    
    // البحث في قاعدة البيانات باسم المنتج
    $products = \App\Models\Product::where('name', 'LIKE', '%' . $term . '%')
        ->limit(10) // جلب 10 نتائج فقط لتسريع البحث
        ->get();

    $formatted = [];
    foreach ($products as $product) {
        $formatted[] = [
            'id' => $product->id,
            'text' => $product->name . ' - ' . number_format($product->price, 2) . ' شيكل'
        ];
    }

    return response()->json(['results' => $formatted]);
}
    public function destroy(Product $product)
    {
        // حذف الصورة من التخزين قبل حذف السجل
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->back()->with('success', 'تم حذف المنتج');
    }
}