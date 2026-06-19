@extends('layout.admin')

@section('content')
<div class="max-w-5xl">
    <h1 class="text-2xl font-medium text-neutral-900 mb-12">لوحة التحكم</h1>

    <div class="grid grid-cols-3 gap-16 mb-20">
        @foreach(['المبيعات' => '84,200', 'الطلبات' => '1,204', 'المنتجات' => '42'] as $title => $value)
        <div>
            <p class="text-[10px] font-semibold text-neutral-400 uppercase tracking-widest">{{ $title }}</p>
            <h2 class="text-4xl font-light text-neutral-900 mt-3">{{ $value }}</h2>
        </div>
        @endforeach
    </div>

    <div class="mt-10">
        <h3 class="text-xs font-bold text-neutral-900 mb-6 uppercase tracking-wider">أحدث العمليات</h3>
        <table class="w-full text-right">
            <tbody class="text-sm">
                <tr class="border-b border-neutral-50">
                    <td class="py-5 font-medium">ساعة ذكية x5</td>
                    <td class="py-5 text-neutral-400">محمد خالد</td>
                    <td class="py-5 text-neutral-900 font-medium">250 ₪</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection