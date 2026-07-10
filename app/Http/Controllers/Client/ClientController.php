<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * عرض لوحة تحكم العميل مع الحساب المالي والعمليات الأخيرة
     */
    public function index()
    {
        $user = Auth::user();
        $customer = $user->customerProfile;

        // التحقق من وجود بروفايل للعميل لتجنب أخطاء التحميل
        if (!$customer) {
            return redirect()->back()->with('error', 'لا يوجد بيانات حساب مرتبطة بهذا المستخدم.');
        }

        // جلب البيانات
        $orders = $customer->orders()->latest()->get();
        $invoices = $customer->invoices()->latest()->get();
        $payments = $customer->payments()->latest()->get();

        // 1. حساب صافي الدين
        // ملاحظة: تأكد أن الفواتير لها مجموع أو حقل خاص بالمبلغ
        $totalDebt = $invoices->sum('total_amount') - $payments->sum('amount');

        // 2. دمج الفواتير والمدفوعات في متغير واحد $activities
        $activities = collect();

        foreach ($invoices as $invoice) {
            $activities->push(['date' => $invoice->created_at, 'type' => 'invoice', 'data' => $invoice]);
        }

        foreach ($payments as $payment) {
            $activities->push(['date' => $payment->created_at, 'type' => 'payment', 'data' => $payment]);
        }

        // ترتيب العمليات من الأحدث للأقدم
        $activities = $activities->sortByDesc('date');

        return view('client.dashboard', compact('customer', 'orders', 'activities', 'totalDebt'));
    }

    /**
     * عرض تفاصيل طلب معين للعميل مع التأكد من ملكيته للطلب
     */
    public function showOrder($id)
    {
        $customer = Auth::user()->customerProfile;

        if (!$customer) {
            abort(404);
        }

        $order = $customer->orders()->findOrFail($id);

        return view('client.order_details', compact('order'));
    }

    /**
     * عرض قائمة جميع طلبات العميل
     */
    public function indexOrders()
    {
        $customer = Auth::user()->customerProfile;

        if (!$customer) {
            return redirect()->back()->with('error', 'لا يوجد بيانات حساب.');
        }

        $orders = $customer->orders()->latest()->get();
        
        return view('client.orders', compact('orders'));
    }
}