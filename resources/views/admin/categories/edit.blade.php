@extends('layout.admin')

@section('content')
<div class="max-w-xl" dir="rtl">
    <h1 class="text-2xl font-medium text-neutral-900 mb-12">تعديل القسم</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        
        {{-- اسم القسم --}}
        <div class="mb-8">
            <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">اسم القسم</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" 
                   class="w-full mt-2 pb-2 bg-transparent border-b border-neutral-200 outline-none focus:border-black transition text-lg text-neutral-900">
        </div>

        {{-- حقل الصورة مع المعاينة --}}
        <div class="mb-12">
            <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest block mb-4">صورة القسم</label>
            
            <div class="mb-4">
                <img id="imagePreview" 
                     src="{{ $category->image ? asset($category->image) : '' }}" 
                     alt="Category Image" 
                     class="w-24 h-24 object-cover rounded-sm border border-neutral-200 {{ $category->image ? '' : 'hidden' }}">
                
                <div id="noImagePlaceholder" class="w-24 h-24 flex items-center justify-center bg-neutral-100 border border-neutral-200 rounded-sm text-[10px] text-neutral-400 {{ $category->image ? 'hidden' : '' }}">
                    بدون صورة
                </div>
            </div>

            <input type="file" name="image" id="imageInput" accept="image/*" 
                   onchange="previewImage(event)"
                   class="w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-[10px] file:bg-neutral-100 hover:file:bg-neutral-200 cursor-pointer">
            
            <p class="text-[9px] text-neutral-400 mt-2 italic">اترك الحقل فارغاً إذا كنت لا ترغب في تغيير الصورة الحالية.</p>
        </div>

        <div class="flex items-center gap-6">
            <button type="submit" 
                    class="bg-black text-white px-8 py-2 text-[10px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition">
                حفظ التغييرات
            </button>
            
            <a href="{{ route('categories.index') }}" 
               class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest hover:text-black transition">
                إلغاء
            </a>
        </div>
    </form>
</div>

{{-- كود الجافا سكريبت للمعاينه --}}
<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const noImagePlaceholder = document.getElementById('noImagePlaceholder');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                noImagePlaceholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection