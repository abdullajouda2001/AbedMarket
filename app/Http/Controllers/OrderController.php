<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // جلب الطلبات الخاصة بالمستخدم المسجل حالياً فقط
        // $orders = Order::where('user_id', Auth::id())
        //                 ->latest() // لترتيب الطلبات من الأحدث للأقدم
        //                 ->get();
 $orders = Order::where('user_id', Auth::id())
                   ->orderBy('created_at', 'desc')
                   ->get();
    
    // return view('orders.index', compact('orders'));
        // إرجاع الصفحة مع تمرير بيانات الطلبات
        return view('store.orders', compact('orders'));
    }
  public function checkout(Request $request)
{
    // 1. التحقق من وصول البيانات
    if (!$request->has('customer_name')) {
        return back()->with('error', 'البيانات لم تصل للكنترولر!');
    }

    $cart = session()->get('cart', []);
    if (empty($cart)) return back()->with('error', 'السلة فارغة!');

    // 2. الحفظ مع إظهار أي خطأ في Validation الـ Model
    try {
        $order = new Order();
        $order->user_id        = Auth::id();
        $order->customer_name  = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->address        = $request->address;
        $order->subtotal       = array_sum(array_column($cart, 'price')); // حساب بسيط
        $order->delivery_fee   = 15.00;
        $order->total_price    = $order->subtotal + 15.00;
        $order->bonus_amount   = 0;
        $order->status         = 'pending';
        $order->payment_status = 'unpaid';

        // استخدام save() بدلاً من create() لنرى هل هناك خطأ في حفظ الـ Model
        if ($order->save()) {
            // نجح الحفظ، لنحفظ المنتجات
            foreach ($cart as $productId => $details) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $details['quantity'],
                    'price'      => $details['price'],
                ]);
            }
            session()->forget('cart');
            return redirect()->route('orders.index')->with('success', 'تم الطلب بنجاح!');
        } else {
            return back()->with('error', 'فشل حفظ الطلب في قاعدة البيانات!');
        }

    } catch (\Exception $e) {
        // طباعة الخطأ الحقيقي على الشاشة
        dd($e->getMessage()); 
    }
}
}