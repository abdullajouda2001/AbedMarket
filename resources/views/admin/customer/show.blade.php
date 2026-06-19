@extends('layout.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white p-8 rounded-lg border border-neutral-100 mb-8">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold">{{ $customer->user->name }}</h2>
                <p class="text-neutral-400 text-sm">{{ $customer->user->email }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('customer.edit', $customer->id) }}" class="text-xs bg-neutral-100 px-4 py-2 font-bold uppercase tracking-widest hover:bg-neutral-200 transition">تعديل</a>
                <button onclick="confirmDelete('{{ $customer->id }}')" class="text-xs bg-red-50 text-red-600 px-4 py-2 font-bold uppercase tracking-widest hover:bg-red-100 transition">حذف</button>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 border-t pt-8">
            <div>
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">الهاتف</p>
                <p class="text-sm font-medium">{{ $customer->phone ?? 'غير متوفر' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">الرصيد الحالي</p>
                <p class="text-sm font-bold">
                    @if($customer->current_balance > 0)
                        <span class="text-green-600">له: {{ number_format($customer->current_balance, 2) }} شيكل</span>
                    @elseif($customer->current_balance < 0)
                        <span class="text-red-600">عليه: {{ number_format(abs($customer->current_balance), 2) }} شيكل</span>
                    @else
                        <span class="text-neutral-500">0.00 شيكل</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg border border-neutral-100">
            <h3 class="text-[11px] font-bold mb-4 uppercase text-neutral-400">إضافة منتج (بحث ذكي)</h3>
            <form action="{{ route('invoice.store', $customer->id) }}" method="POST" class="flex flex-col gap-2">
                @csrf
                <select name="product_id" id="product-search" class="w-full" required>
                    <option value="">ابدأ بكتابة اسم المنتج...</option>
                </select>
                <input type="number" name="quantity" placeholder="الكمية" class="bg-neutral-50 border p-2 text-sm w-full outline-none" required>
                <button type="submit" class="bg-black text-white py-2 text-[11px] font-bold uppercase hover:bg-neutral-800 transition">إضافة للفاتورة</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg border border-neutral-100">
            <h3 class="text-[11px] font-bold mb-4 uppercase text-neutral-400">تسجيل دفعة (سداد)</h3>
            <form action="{{ route('payment.store', $customer->id) }}" method="POST" class="flex flex-col gap-2">
                @csrf
                <input type="number" step="0.01" name="amount" placeholder="مبلغ التسديد" class="bg-neutral-50 border p-2 text-sm outline-none" required>
                <button type="submit" class="bg-green-600 text-white py-2 text-[11px] font-bold uppercase hover:bg-green-700 transition mt-6">تأكيد التسديد</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-neutral-100 overflow-hidden">
        <table class="w-full text-sm text-right">
            <thead class="bg-neutral-50 text-neutral-500 uppercase text-[10px]">
                <tr>
                    <th class="px-6 py-4">التاريخ والوقت</th>
                    <th class="px-6 py-4">النوع</th>
                    <th class="px-6 py-4">التفاصيل</th>
                    <th class="px-6 py-4">القيمة</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @foreach($activities as $activity)
                <tr>
                    <td class="px-6 py-4 text-neutral-500">{{ $activity['date']->format('Y-m-d') }} <br> <span class="text-[10px] text-neutral-400">{{ $activity['date']->format('H:i') }}</span></td>
                    <td class="px-6 py-4 font-bold"><span class="{{ $activity['type'] == 'invoice' ? 'text-red-600' : 'text-green-600' }}">{{ $activity['type'] == 'invoice' ? 'بضاعة' : 'سداد' }}</span></td>
                    <td class="px-6 py-4">{{ $activity['type'] == 'invoice' ? $activity['data']->items->pluck('product_name')->implode(', ') : 'دفعة نقدية' }}</td>
                    <td class="px-6 py-4 font-bold">{{ number_format($activity['data']->total_amount ?? $activity['data']->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#product-search').select2({
            ajax: {
                url: "{{ route('products.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) { return { term: params.term }; },
                processResults: function (data) { return { results: data.results }; }
            },
            minimumInputLength: 2,
            width: '100%'
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف بيانات العميل نهائياً!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('customer.destroy', $customer->id) }}";
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        })
    }
</script>
@endsection