@extends('layout.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-2xl font-medium">الطلبات</h1>
        <span class="text-neutral-400 text-sm">إجمالي الطلبات: {{ $orders->count() }}</span>
    </div>

    <div class="bg-white rounded-lg border border-neutral-100">
        @forelse($orders as $order)
        <div class="flex items-center justify-between p-6 border-b border-neutral-100 last:border-0">
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-neutral-500 text-lg">📦</span>
                </div>
                <div>
                    <span class="text-sm font-medium block">{{ $order->customer_name }}</span>
                    <span class="text-[10px] text-neutral-400 uppercase">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>

            <div class="text-right">
                <span class="text-sm font-bold block">{{ number_format($order->total_price, 2) }} شيكل</span>
                <span class="text-[10px] font-bold block uppercase 
                    {{ $order->status == 'pending' ? 'text-orange-500' : 'text-green-600' }}">
                    {{ $order->status }}
                </span>
            </div>

            <div style="display: inline-flex !important; align-items: center !important; gap: 15px !important; flex-shrink: 0 !important;">
                
                <a href="{{ route('admin.orders.show', $order->id) }}" 
                   style="font-size: 11px !important; font-weight: bold !important; color: #000000 !important; text-decoration: none !important;">
                   عرض
                </a>
                
                <span style="color: #d4d4d4 !important; font-size: 14px !important; font-weight: 300;">|</span>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <select name="status" onchange="this.form.submit()" style="font-size: 11px; font-weight: bold; border: none; cursor: pointer; color: #737373;">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>جاري التجهيز</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                    </select>
                </form>

                <span style="color: #d4d4d4 !important; font-size: 14px !important; font-weight: 300;">|</span>

                <button type="button" 
                        onclick="confirmDelete('{{ $order->id }}')"
                        style="font-size: 11px !important; font-weight: bold !important; color: #ef4444 !important; background: none !important; border: none !important; cursor: pointer !important;">
                    حذف
                </button>

                <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display: none;">
                    @csrf 
                    @method('DELETE')
                </form>
            </div> 
        </div>
        @empty
        <div class="p-10 text-center text-neutral-400">لا توجد طلبات حالياً</div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "سيتم حذف هذا الطلب نهائياً!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#000000',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذفه!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection