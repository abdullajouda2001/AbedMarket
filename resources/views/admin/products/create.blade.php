@extends('layout.admin')

@section('content')
<div class="max-w-xl">
    <div class="mb-12">
        <h1 class="text-2xl font-medium text-neutral-900">منتج جديد</h1>
        <p class="text-[10px] text-neutral-400 uppercase tracking-widest mt-1">قم بتعبئة بيانات المنتج لإضافته إلى المتجر</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        
        <div>
            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">القسم</label>
            <select name="category_id" class="w-full pb-3 bg-transparent border-b border-neutral-200 outline-none focus:border-black transition text-sm">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div>
                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">اسم المنتج</label>
                <input type="text" name="name" required class="w-full pb-3 bg-transparent border-b border-neutral-200 outline-none focus:border-black transition text-sm">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">السعر</label>
                <input type="number" step="0.01" name="price" required class="w-full pb-3 bg-transparent border-b border-neutral-200 outline-none focus:border-black transition text-sm">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div>
                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">المخزون</label>
                <input type="number" name="stock" required class="w-full pb-3 bg-transparent border-b border-neutral-200 outline-none focus:border-black transition text-sm">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">صورة المنتج</label>
                <input type="file" name="image" class="w-full text-[10px] text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:bg-neutral-100 file:text-neutral-600 hover:file:bg-neutral-200 transition">
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-3">الوصف</label>
            <textarea name="description" rows="3" class="w-full pb-3 bg-transparent border-b border-neutral-200 outline-none focus:border-black transition text-sm"></textarea>
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-black text-white py-4 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition">
                حفظ المنتج
            </button>
        </div>
    </form>
</div>
@endsection