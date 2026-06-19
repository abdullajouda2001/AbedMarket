@extends('layout.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-2xl font-medium">العملاء</h1>
        <a href="{{ route('customer.create') }}" 
            class="bg-black text-white px-6 py-2 text-[11px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition">
            إضافة عميل جديد
        </a>
    </div>

    <div class="bg-white rounded-lg border border-neutral-100">
        @foreach($customers as $customer)
        <div class="flex items-center justify-between p-6 border-b border-neutral-100 last:border-0">
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-neutral-500 text-lg">👤</span>
                </div>
                <div>
                    <span class="text-sm font-medium block">{{ $customer->user->name }}</span>
                    <span class="text-[10px] text-neutral-400 uppercase">{{ $customer->user->email }}</span>
                </div>
            </div>

            <div class="text-right">
                <span class="text-sm font-bold block">{{ $customer->phone }}</span>
                
                <span class="text-[10px] font-bold">
                    @if($customer->current_balance > 0)
                        <span class="text-green-600">له رصيد: {{ number_format($customer->current_balance, 2) }} شيكل</span>
                    @elseif($customer->current_balance < 0)
                        <span class="text-red-600">عليه دين: {{ number_format(abs($customer->current_balance), 2) }} شيكل</span>
                    @else
                        <span class="text-neutral-500">الرصيد: 0.00 شيكل</span>
                    @endif
                </span>
            </div>

            <div style="display: inline-flex !important; align-items: center !important; gap: 15px !important; flex-shrink: 0 !important;">
                
                <a href="{{ route('customer.show', $customer->id) }}" 
                   style="font-size: 11px !important; font-weight: bold !important; color: #000000 !important; text-decoration: none !important;">
                   عرض
                </a>
                
                <span style="color: #d4d4d4 !important; font-size: 14px !important; font-weight: 300;">|</span>

                <a href="{{ route('customer.edit', $customer->id) }}" 
                   style="font-size: 11px !important; font-weight: bold !important; color: #737373 !important; text-decoration: none !important;">
                   تعديل
                </a>
                
                <span style="color: #d4d4d4 !important; font-size: 14px !important; font-weight: 300;">|</span>

                <button type="button" 
                        onclick="confirmDelete('{{ $customer->id }}')"
                        style="font-size: 11px !important; font-weight: bold !important; color: #ef4444 !important; background: none !important; border: none !important; cursor: pointer !important;">
                    حذف
                </button>

                <form id="delete-form-{{ $customer->id }}" action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display: none;">
                    @csrf 
                    @method('DELETE')
                </form>
            </div> 
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "سيتم حذف العميل وكل ما يتعلق به نهائياً!",
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