@extends('layout.admin')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-medium text-neutral-900 mb-16">إعدادات الحساب</h1>
@if (session('status') === 'profile-updated')
    <div class="mb-8 bg-neutral-900 text-white text-[10px] px-4 py-2 rounded-sm inline-block uppercase tracking-widest">
        تم تحديث البيانات بنجاح
    </div>
@endif
    <div class="space-y-24">
        
        <section>
            <h2 class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-8">معلومات الملف الشخصي</h2>
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf @method('patch')
                <div>
                    <label class="text-[10px] font-bold text-neutral-400">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-2 pb-2 border-b border-neutral-200 outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-neutral-400">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-2 pb-2 border-b border-neutral-200 outline-none focus:border-black transition">
                </div>
                <button type="submit" class="bg-black text-white px-8 py-2 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition">حفظ التغييرات</button>
            </form>
        </section>

        <section class="border-t border-neutral-100 pt-16">
            <h2 class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-8">تغيير كلمة المرور</h2>
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf @method('put')
                <div>
                    <label class="text-[10px] font-bold text-neutral-400">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" class="w-full mt-2 pb-2 border-b border-neutral-200 outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-neutral-400">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="w-full mt-2 pb-2 border-b border-neutral-200 outline-none focus:border-black transition">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-neutral-400">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="password_confirmation" class="w-full mt-2 pb-2 border-b border-neutral-200 outline-none focus:border-black transition">
                </div>
                <button type="submit" class="bg-black text-white px-8 py-2 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition">تحديث كلمة المرور</button>
            </form>
        </section>

        <section class="border-t border-neutral-100 pt-16">
            <h2 class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-4">منطقة الخطر</h2>
            <p class="text-sm text-neutral-500 mb-8">بمجرد حذف حسابك، سيتم مسح كافة البيانات بشكل نهائي.</p>
            
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                 @method('delete')
                <div class="mb-6">
                    <input type="password" name="password" placeholder="أدخل كلمة المرور لتأكيد الحذف" class="w-full pb-2 border-b border-neutral-200 outline-none focus:border-red-500 transition">
                </div>
                <button type="submit" class="bg-red-500 text-white px-8 py-2 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-red-600 transition">حذف الحساب نهائياً</button>
            </form>
        </section>

    </div>
</div>
@endsection