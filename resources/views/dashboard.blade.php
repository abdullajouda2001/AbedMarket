@extends('layout.admin')

@section('content')
<div class="max-w-5xl">
    <h1 class="text-2xl font-medium text-neutral-900 mb-12">لوحة التحكم</h1>

    {{-- الإحصائيات الأوتوماتيكية --}}
    <div class="grid grid-cols-3 gap-16 mb-20">
        {{-- هنا نمرر مصفوفة $stats التي جلبناها من Controller --}}
        @foreach($stats as $title => $value)
        <div>
            <p class="text-[10px] font-semibold text-neutral-400 uppercase tracking-widest">{{ $title }}</p>
            <h2 class="text-4xl font-light text-neutral-900 mt-3">
                {{-- تنسيق الأرقام: عرض المبيعات بعملة معينة --}}
                {{ $title == 'المبيعات' ? number_format($value, 2) . ' ₪' : number_format($value) }}
            </h2>
        </div>
        @endforeach
    </div>

    {{-- جدول أحدث الطلبات الأوتوماتيكي --}}
    <div class="mt-10">
        <h3 class="text-xs font-bold text-neutral-900 mb-6 uppercase tracking-wider">أحدث العمليات</h3>
        <table class="w-full text-right">
            <tbody class="text-sm">
                @forelse($latestOrders as $order)
                <tr class="border-b border-neutral-50">
                    {{-- جلب اسم المنتج من علاقة الطلب، واسم العميل من علاقة المستخدم --}}
                    <td class="py-5 font-medium">{{ $order->product_name ?? 'منتج غير محدد' }}</td>
                    <td class="py-5 text-neutral-400">{{ $order->user->name ?? 'عميل' }}</td>
                    <td class="py-5 text-neutral-900 font-medium">{{ number_format($order->total_price, 2) }} ₪</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-5 text-center text-neutral-400">لا توجد عمليات بيع حالياً</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection