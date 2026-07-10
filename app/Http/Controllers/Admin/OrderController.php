<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. عرض قائمة جميع الطلبات
    public function index()
    {
        // نجلب الطلبات مع معلومات المستخدم إذا كان مسجلاً
        $orders = Order::latest()->paginate(20); 
        return view('admin.orders.index', compact('orders'));
    }

    // 2. عرض تفاصيل طلب معين (مع المنتجات التي يحتويها)
    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. تحديث حالة الطلب (مثلاً من pending إلى delivered)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    // 4. حذف طلب (اختياري)
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'تم حذف الطلب بنجاح.');
    }
}