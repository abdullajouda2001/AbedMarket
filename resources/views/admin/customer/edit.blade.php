@extends('layout.admin')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-medium mb-8">تعديل بيانات العميل: {{ $customer->user->name }}</h1>

    <form action="{{ route('customer.update', $customer->id) }}" method="POST" class="bg-white p-8 rounded-lg border border-neutral-100">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-bold uppercase text-neutral-500 mb-2">الاسم</label>
                <input type="text" name="name" value="{{ old('name', $customer->user->name) }}" class="w-full bg-neutral-50 border border-neutral-200 p-3 text-sm outline-none transition focus:border-black">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase text-neutral-500 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email', $customer->user->email) }}" class="w-full bg-neutral-50 border border-neutral-200 p-3 text-sm outline-none transition focus:border-black">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase text-neutral-500 mb-2">الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full bg-neutral-50 border border-neutral-200 p-3 text-sm outline-none transition focus:border-black">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase text-neutral-500 mb-2">الوضع المالي للعميل</label>
                <div class="flex gap-2">
                    <input type="number" 
                           step="0.01" 
                           name="amount" 
                           value="{{ old('amount', abs($customer->current_balance)) }}" 
                           class="w-full bg-neutral-50 border border-neutral-200 p-3 text-sm outline-none transition focus:border-black" 
                           placeholder="المبلغ">
                    
                    <select name="balance_type" class="bg-neutral-50 border border-neutral-200 p-3 text-sm outline-none text-neutral-600">
                        <option value="credit" {{ $customer->current_balance >= 0 ? 'selected' : '' }}>له رصيد</option>
                        <option value="debit" {{ $customer->current_balance < 0 ? 'selected' : '' }}>عليه دين</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="bg-black text-white px-8 py-3 text-[11px] font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                حفظ التعديلات
            </button>
            <a href="{{ route('customer.index') }}" class="mr-4 text-xs text-neutral-500 hover:text-black">إلغاء</a>
        </div>
    </form>
</div>
@endsection