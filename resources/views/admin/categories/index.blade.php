@extends('layout.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4" dir="rtl">
    <h1 class="text-2xl font-medium text-neutral-900 mb-12">إدارة الأقسام</h1>

    {{-- رسائل التنبيه --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 text-[10px] uppercase tracking-widest rounded-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded text-xs">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    {{-- فورم الإضافة --}}
    <div class="bg-neutral-50 p-6 rounded-lg border border-neutral-200 mb-8">
        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-6 items-end" enctype="multipart/form-data">
            @csrf
            
            <div class="flex-grow">
                <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2">اسم القسم الجديد</label>
                <input type="text" name="name" required placeholder="أدخل اسم القسم..." 
                       class="w-full pb-2 bg-transparent border-b border-neutral-300 outline-none focus:border-black transition text-sm">
            </div>

            {{-- منطقة رفع الصورة مع المعاينة --}}
            <div class="flex items-center gap-4">
                {{-- مربع المعاينة يظهر فقط عند اختيار صورة --}}
                <div id="previewContainer" class="w-12 h-12 rounded-sm border border-neutral-200 bg-white flex items-center justify-center overflow-hidden hidden">
                    <img id="imagePreview" src="#" alt="Preview" class="w-full h-full object-cover">
                </div>

                <div class="w-48">
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2">صورة القسم</label>
                    <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(event)"
                           class="w-full text-xs text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-[10px] file:bg-neutral-200 hover:file:bg-neutral-300 cursor-pointer">
                </div>
            </div>

            <button type="submit" class="bg-black text-white px-8 py-3 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition whitespace-nowrap">
                إضافة
            </button>
        </form>
    </div>

    {{-- قائمة الأقسام --}}
    <div class="bg-white rounded-lg border border-neutral-100">
        @foreach($categories as $category)
        <div class="flex items-center justify-between p-6 border-b border-neutral-100 last:border-0">
            <div class="flex items-center gap-4">
                @if($category->image)
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 object-cover rounded-sm border border-neutral-100">
                @else
                    <div class="w-10 h-10 bg-neutral-100 rounded-sm"></div>
                @endif
                <span class="text-sm font-medium text-neutral-900">{{ $category->name }}</span>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('categories.edit', $category->id) }}" class="text-[11px] text-neutral-500 hover:text-black transition">تعديل</a>
                <span class="text-neutral-200">|</span>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="m-0">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-[11px] text-red-500 hover:text-red-700 transition">حذف</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- سكربت المعاينة الفورية --}}
<script>
    function previewImage(event) {
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden'); // إظهار المربع
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden'); // إخفاء المربع
        }
    }
</script>
@endsection