@extends('layout.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto px-4 py-8">
    {{-- تفاصيل العميل --}}
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

    {{-- الإجراءات السريعة --}}
    <div class="bg-white p-6 rounded-lg border border-neutral-100">
    <h3 class="text-[11px] font-bold mb-4 uppercase text-neutral-400">إضافة منتج (بحث ذكي)</h3>
    
    <!-- فورم واحد فقط -->
    <form id="invoice-form" class="flex flex-col gap-2">
        @csrf
        <!-- الـ Select2 -->
        <select name="product_id" id="product-search" class="w-full" required>
            <option value="">ابدأ بكتابة اسم المنتج...</option>
        </select>
        
        <!-- خانة الكمية -->
        <input type="number" name="quantity" id="quantity" placeholder="الكمية" class="bg-neutral-50 border p-2 text-sm w-full outline-none" required>
        
        <!-- زر الإضافة -->
        <button type="button" onclick="submitInvoice()" class="bg-black text-white py-2 text-[11px] font-bold uppercase hover:bg-neutral-800 transition">
            إضافة للفاتورة
        </button>
    </form>
</div></div>

        <div class="bg-white p-6 rounded-lg border border-neutral-100">
            <h3 class="text-[11px] font-bold mb-4 uppercase text-neutral-400">تسجيل دفعة (سداد)</h3>
            <form action="{{ route('payment.store', $customer->id) }}" method="POST" class="flex flex-col gap-2">
                @csrf
                <input type="number" step="0.01" name="amount" placeholder="مبلغ التسديد" class="bg-neutral-50 border p-2 text-sm outline-none" required>
                <button type="submit" class="bg-green-600 text-white py-2 text-[11px] font-bold uppercase hover:bg-green-700 transition mt-6">تأكيد التسديد</button>
            </form>
        </div>
    </div>

    {{-- جدول المعاملات مع البحث --}}
    <div class="bg-white rounded-lg border border-neutral-100 overflow-hidden">
        <div class="p-4 border-b">
            <input type="text" id="transactionSearch" placeholder="🔍 بحث سريع في السجل..." class="w-full p-2 border rounded text-sm outline-none">
        </div>
        <table class="w-full text-sm text-right">
            <thead class="bg-neutral-50 text-neutral-500 uppercase text-[10px]">
                <tr>
                    <th class="px-6 py-4">التاريخ</th>
                    <th class="px-6 py-4">النوع</th>
                    <th class="px-6 py-4">التفاصيل</th>
                    <th class="px-6 py-4">القيمة</th>
                    <th class="px-6 py-4">إجراءات</th>
                </tr>
            </thead>
            <tbody id="transactionsBody" class="divide-y divide-neutral-100">
                @foreach($activities as $activity)
                <tr>
                    <td class="px-6 py-4 text-neutral-500">{{ $activity['date']->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 font-bold">
                        <span class="{{ $activity['type'] == 'invoice' ? 'text-red-600' : 'text-green-600' }}">
                            {{ $activity['type'] == 'invoice' ? 'بضاعة' : 'سداد' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $activity['type'] == 'invoice' ? $activity['data']->items->pluck('product_name')->implode(', ') : 'دفعة نقدية' }}</td>
                    <td class="px-6 py-4 font-bold">{{ number_format($activity['data']->total_amount ?? $activity['data']->amount, 2) }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <button onclick="editItem('{{ $activity['type'] }}', '{{ $activity['data']->id }}', '{{ $activity['data']->quantity ?? $activity['data']->amount }}')" class="text-blue-500 hover:text-blue-700 font-bold text-xs">تعديل</button>
                        <button onclick="confirmDeleteActivity('{{ $activity['type'] }}', '{{ $activity['data']->id }}')" class="text-red-500 hover:text-red-700 font-bold text-xs">حذف</button>
                    </td>
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
    // 1. البحث الفوري في الجدول (Search in Table)
    document.getElementById('transactionSearch').addEventListener('keyup', function() {
        let term = this.value.toLowerCase();
        document.querySelectorAll('#transactionsBody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
        });
    });

    // 2. إعداد الـ Select2 للبحث الذكي
    $(document).ready(function() {
        $('#product-search').select2({
            placeholder: "ابدأ بكتابة اسم المنتج...",
            minimumInputLength: 0, // يسمح بفتح القائمة فوراً عند الضغط
            ajax: {
                url: "{{ route('products.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '' // يرسل النص المدخل أو فراغ للجلب الشامل
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results // يتوقع تنسيق JSON: { "results": [ {"id": 1, "text": "..."} ] }
                    };
                },
                cache: true
            },
            width: '100%'
        });
    });

    // 3. دالة الإضافة بدون Reload (AJAX)
    function submitInvoice() {
        let productId = $('#product-search').val();
        let qty = $('#quantity').val();

        if(!productId || !qty) {
            Swal.fire('تنبيه', 'يرجى اختيار المنتج وتحديد الكمية', 'warning');
            return;
        }

        $.ajax({
            url: "{{ route('invoice.store', $customer->id) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                quantity: qty
            },
            success: function(response) {
                Swal.fire('تمت الإضافة!', 'تم إضافة المنتج للفاتورة بنجاح', 'success').then(() => {
                    location.reload(); // تحديث الصفحة لرؤية البيانات الجديدة في الجدول
                });
            },
            error: function(xhr) {
                Swal.fire('خطأ', 'فشل الإضافة، تأكد من البيانات المدخلة', 'error');
            }
        });
    }

    // 4. حذف العميل
    function confirmDelete(id) {
        Swal.fire({ title: 'هل أنت متأكد؟', icon: 'warning', showCancelButton: true, confirmButtonText: 'نعم' }).then((r) => {
            if (r.isConfirmed) {
                const f = document.createElement('form'); 
                f.method = 'POST'; 
                f.action = "{{ route('customer.destroy', $customer->id) }}"; 
                f.innerHTML = '@csrf @method("DELETE")'; 
                document.body.appendChild(f); 
                f.submit();
            }
        });
    }

    // 5. حذف معاملة (فاتورة أو دفعة)
    function confirmDeleteActivity(type, id) {
        Swal.fire({ title: 'هل أنت متأكد؟', icon: 'warning', showCancelButton: true, confirmButtonText: 'نعم' }).then((r) => {
            if (r.isConfirmed) {
                const f = document.createElement('form'); 
                f.method = 'POST'; 
                f.action = (type === 'invoice') ? "/admin/invoice/" + id : "/admin/payment/" + id; 
                f.innerHTML = '@csrf @method("DELETE")'; 
                document.body.appendChild(f); 
                f.submit();
            }
        });
    }

    // 6. تعديل معاملة
    function editItem(type, id, currentVal) {
        Swal.fire({ 
            title: 'تعديل القيمة', 
            input: 'number', 
            inputValue: currentVal, 
            showCancelButton: true, 
            confirmButtonText: 'تحديث' 
        }).then((r) => {
            if (r.isConfirmed) {
                const f = document.createElement('form'); 
                f.method = 'POST'; 
                f.action = (type === 'invoice') ? "/admin/invoice/" + id : "/admin/payment/" + id; 
                f.innerHTML = '@csrf @method("PUT") <input type="hidden" name="' + (type === 'invoice' ? 'quantity' : 'amount') + '" value="' + r.value + '">'; 
                document.body.appendChild(f); 
                f.submit();
            }
        });
    }
</script>
@endsection