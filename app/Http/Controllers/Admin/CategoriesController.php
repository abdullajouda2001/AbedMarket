<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // لاستخدام الحذف أو التعديل إذا لزم الأمر

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

   public function store(Request $request)
{
    // قمنا بزيادة max من 2048 إلى 5120 (5 ميجابايت)
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
    ]);

    $data = ['name' => $request->name];

    if ($request->hasFile('image')) {
        // التأكد من أن المجلد موجود قبل النقل
        $destinationPath = public_path('assets/images/categories');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move($destinationPath, $imageName);
        $data['image'] = 'assets/images/categories/' . $imageName;
    }

    Category::create($data);

    return redirect()->back()->with('success', 'تم إضافة القسم بنجاح');
}

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

public function update(Request $request, Category $category)
{
    // تم زيادة القيد إلى 5120 (5 ميجابايت)
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    $data = ['name' => $request->name];

    if ($request->hasFile('image')) {
        // 1. حذف الصورة القديمة إذا كانت موجودة
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        // 2. التأكد من أن المجلد موجود
        $destinationPath = public_path('assets/images/categories');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // 3. رفع الصورة الجديدة
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move($destinationPath, $imageName);
        $data['image'] = 'assets/images/categories/' . $imageName;
    }

    $category->update($data);

    return redirect()->route('categories.index')->with('success', 'تم التحديث بنجاح');
}   public function destroy($id)
{
    $category = Category::findOrFail($id);

    // التحقق هل توجد منتجات مرتبطة بهذا التصنيف
    if ($category->products()->count() > 0) {
        return redirect()->back()->with('error', 'لا يمكن حذف هذا التصنيف لأنه يحتوي على منتجات!');
    }

    $category->delete();
    return redirect()->back()->with('success', 'تم حذف التصنيف بنجاح');
}
}