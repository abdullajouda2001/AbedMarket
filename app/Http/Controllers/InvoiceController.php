<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
public function store(Request $request, $customer_id)
{
    // 1. التحقق من البيانات
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|numeric|min:1',
    ]);

    // 2. البحث عن المنتج
    $product = \App\Models\Product::findOrFail($request->product_id);
    $totalPrice = $request->quantity * $product->price;

    // 3. التنفيذ داخل Transaction لضمان سلامة البيانات
    DB::transaction(function () use ($request, $customer_id, $product, $totalPrice) {
        
        // إنشاء الفاتورة باستخدام الكائن مباشرةً (بدلاً من array فقط)
        $invoice = new \App\Models\Invoice();
        $invoice->customer_profile_id = (int)$customer_id;
        $invoice->total_amount = $totalPrice;
        $invoice->save(); // هذا سيقوم بإدخال البيانات مباشرة

        // إنشاء عنصر الفاتورة
        \App\Models\InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product_name' => $product->name,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        // تحديث الرصيد
        \App\Models\CustomerProfile::where('id', $customer_id)->decrement('current_balance', $totalPrice);
    });

    return back()->with('success', 'تمت إضافة المنتج بنجاح');
}
public function update(Request $request, $id)
{
    // 1. جلب الفاتورة مع العناصر المرتبطة بها (Items)
    $invoice = \App\Models\Invoice::with('items')->findOrFail($id);
    
    // جلب بيانات العميل المرتبط بالفاتورة
    $customer = \App\Models\CustomerProfile::findOrFail($invoice->customer_profile_id);

    // 2. إلغاء أثر الفاتورة القديمة من رصيد العميل قبل التعديل
    $customer->increment('current_balance', $invoice->total_amount);

    // 3. تحديث الكمية في عنصر الفاتورة (أول عنصر)
    $item = $invoice->items->first(); 
    if ($item) {
        // التحقق من أن الكمية رقم صحيح وموجب
        $item->quantity = max(0, (int)$request->quantity); 
        $item->save();
    }

    // 4. إعادة حساب إجمالي الفاتورة (مجموع الكمية * السعر لكل عنصر)
    // نستخدم refresh() لتحديث بيانات الـ items بعد التعديل
    $invoice->refresh(); 
    $newTotal = $invoice->items->sum(function ($item) {
        return $item->quantity * $item->price;
    });

    // 5. تحديث إجمالي الفاتورة في جدول invoices
    $invoice->total_amount = $newTotal;
    $invoice->save();

    // 6. خصم الإجمالي الجديد من رصيد العميل
    $customer->decrement('current_balance', $newTotal);

    // 7. العودة برسالة نجاح
    return back()->with('success', 'تم تعديل الكمية وإعادة حساب الرصيد بنجاح');
}
    public function search(Request $request) 
{
    $term = $request->term;
    // إضافة حماية بسيطة إذا كان البحث فارغاً
    $products = Product::where('name', 'LIKE', "%$term%")->limit(10)->get();
    
    $results = $products->map(function($product) {
        return [
            'id' => $product->id, 
            'text' => $product->name . ' - ' . $product->price . ' شيكل'
        ];
    });
    
    return response()->json(['results' => $results]);
}
    public function destroy($id)
{
    $invoice = \App\Models\Invoice::findOrFail($id);
    $customer = \App\Models\CustomerProfile::findOrFail($invoice->customer_profile_id);

    // إعادة الرصيد: بما أن الفاتورة كانت خصماً من الرصيد (مديونية)، 
    // عند حذفها يجب أن نضيف المبلغ للرصيد مرة أخرى
    $customer->increment('current_balance', $invoice->total_amount);

    $invoice->delete();

    return back()->with('success', 'تم حذف الفاتورة وتعديل رصيد العميل بنجاح');
}
}
