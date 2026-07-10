<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction; // تأكد من استيراد الموديل الصحيح لديك

class DashboardController extends Controller
{
    public function index()
    {
        // 1. جلب الإحصائيات (الأرقام)
        $stats = [
            'المبيعات' => Transaction::sum('amount'), // مجموع المبيعات
            'الطلبات' => Order::count(),             // عدد الطلبات الكلي
            'المنتجات' => Product::count(),          // عدد المنتجات الكلي
        ];

        // 2. جلب أحدث الطلبات (مع بيانات المستخدم المرتبط)
        // نستخدم 'with' لتجنب مشكلة الـ N+1 Query (تحسين الأداء)
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // 3. تمرير البيانات للواجهة
        return view('dashboard', compact('stats', 'latestOrders'));
    }
}