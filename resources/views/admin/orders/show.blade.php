@extends('layout.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-medium">تفاصيل الطلب #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-neutral-500 hover:text-black text-sm transition">العودة للطلبات</a>
    </div>

    <div class="bg-white p-6 rounded-lg border border-neutral-100 mb-6">
        <h2 class="text-sm font-bold uppercase mb-4 text-neutral-400">معلومات العميل</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <span class="block text-[10px] text-neutral-400 uppercase">الاسم</span>
                <span class="text-sm font-medium">{{ $order->customer_name }}</span>
            </div>
            <div>
                <span class="block text-[10px] text-neutral-400 uppercase">رقم الهاتف</span>
                <span class="text-sm font-medium">{{ $order->customer_phone }}</span>
            </div>
            <div>
                <span class="block text-[10px] text-neutral-400 uppercase">العنوان</span>
                <span class="text-sm font-medium">{{ $order->address }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-neutral-100">
        <h2 class="text-sm font-bold uppercase p-6 border-b border-neutral-100 text-neutral-400">المنتجات المطلوبة</h2>
        
        @foreach($order->orderItems as $item)
        <div class="flex items-center justify-between p-6 border-b border-neutral-100 last:border-0">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-neutral-100 rounded flex items-center justify-center">
                    <span class="text-neutral-500">🛍️</span>
                </div>
                <div>
                    <span class="text-sm font-medium block">{{ $item->product->name ?? 'منتج غير معروف' }}</span>
                    <span class="text-[10px] text-neutral-400">الكمية: {{ $item->quantity }}</span>
                </div>
            </div>
            <div class="text-right">
                <span class="text-sm font-bold">{{ number_format($item->price * $item->quantity, 2) }} شيكل</span>
            </div>
        </div>
        @endforeach

        <div class="p-6 bg-neutral-50 rounded-b-lg flex justify-between">
            <span class="font-bold">المجموع الكلي:</span>
            <span class="font-bold">{{ number_format($order->total_price, 2) }} شيكل</span>
        </div>
    </div>
</div>
@endsection