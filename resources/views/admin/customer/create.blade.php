@extends('layout.admin')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="mb-12">
        <h1 class="text-2xl font-medium">إضافة عميل جديد</h1>
        <p class="text-[11px] text-neutral-400 uppercase tracking-widest mt-2">إدخال بيانات العميل لربطه بالنظام</p>
    </div>

    <form action="{{ route('customer.store') }}" method="POST" id="customerForm" class="bg-white p-8 border border-neutral-100 rounded-lg">
        @csrf
        <div class="space-y-6">
            
            {{-- حقل الاسم --}}
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2 block">اسم العميل</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full bg-neutral-50 border {{ $errors->has('name') ? 'border-red-500' : 'border-neutral-200' }} p-3 text-sm focus:border-black outline-none transition real-time-input">
                <span class="text-red-500 text-[10px] mt-1 hidden error-text">يجب إدخال اسم العميل</span>
                @error('name') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- حقل البريد الإلكتروني --}}
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2 block">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full bg-neutral-50 border {{ $errors->has('email') ? 'border-red-500' : 'border-neutral-200' }} p-3 text-sm focus:border-black outline-none transition real-time-input">
                <span class="text-red-500 text-[10px] mt-1 hidden error-text">صيغة البريد غير صحيحة</span>
                @error('email') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- حقل كلمة المرور --}}
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2 block">كلمة المرور</label>
                <input type="password" name="password" 
                       class="w-full bg-neutral-50 border {{ $errors->has('password') ? 'border-red-500' : 'border-neutral-200' }} p-3 text-sm focus:border-black outline-none transition real-time-input">
                <span class="text-red-500 text-[10px] mt-1 hidden error-text">كلمة المرور مطلوبة (6 خانات كحد أدنى)</span>
                @error('password') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
    <label class="block text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2">
        الرصيد الافتتاحي
    </label>
    <div class="relative">
        <input type="number" 
               step="0.01" 
               name="current_balance" 
               value="{{ old('current_balance', 0.00) }}"
               placeholder="مثلاً: 500 أو -100 (للدين)"
               class="w-full bg-neutral-50 border border-neutral-200 p-3 text-sm focus:border-black outline-none transition placeholder:text-neutral-300">
        
        <p class="mt-2 text-[10px] text-neutral-400">
            * أدخل قيمة موجبة إذا كان للعميل رصيد، أو قيمة سالبة إذا كان عليه دين.
        </p>
    </div>
</div>

            {{-- حقل الهاتف --}}
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2 block">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone') }}" 
                       class="w-full bg-neutral-50 border {{ $errors->has('phone') ? 'border-red-500' : 'border-neutral-200' }} p-3 text-sm focus:border-black outline-none transition">
                @error('phone') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- حقل العنوان --}}
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-500 mb-2 block">العنوان</label>
                <textarea name="address" rows="3" class="w-full bg-neutral-50 border {{ $errors->has('address') ? 'border-red-500' : 'border-neutral-200' }} p-3 text-sm focus:border-black outline-none transition">{{ old('address') }}</textarea>
                @error('address') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 text-[11px] font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                حفظ العميل في النظام
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.real-time-input').forEach(input => {
        input.addEventListener('blur', function() {
            let isValid = true;
            if (this.type === 'email') {
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            } else if (this.name === 'password') {
                isValid = this.value.length >= 6;
            } else {
                isValid = this.value.trim() !== '';
            }

            const errorText = this.nextElementSibling;
            if (!isValid) {
                this.classList.add('border-red-500');
                errorText.classList.remove('hidden');
            } else {
                this.classList.remove('border-red-500');
                errorText.classList.add('hidden');
            }
        });
    });
</script>
@endsection