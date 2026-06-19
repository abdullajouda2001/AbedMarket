@extends('layout.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10" dir="rtl">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-800">تعديل المنتج</h1>
        <p class="text-neutral-500 text-sm mt-1">قم بتحديث بيانات المنتج أدناه</p>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-neutral-100 shadow-sm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 mb-2">اسم المنتج</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                   class="w-full border border-neutral-200 rounded-xl p-3 focus:ring-2 focus:ring-neutral-200 outline-none transition">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 mb-2">السعر</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" 
                                       class="w-full border border-neutral-200 rounded-xl p-3 focus:ring-2 focus:ring-neutral-200 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 mb-2">التصنيف</label>
                                <select name="category_id" class="w-full border border-neutral-200 rounded-xl p-3 focus:ring-2 focus:ring-neutral-200 outline-none transition">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 mb-2">الكمية (Stock)</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                   class="w-full border border-neutral-200 rounded-xl p-3 focus:ring-2 focus:ring-neutral-200 outline-none transition">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-neutral-100 shadow-sm text-center">
                    <label class="block text-sm font-semibold text-neutral-700 mb-4">صورة المنتج</label>
                    
                    <div class="w-full aspect-square bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200 mb-4 flex items-center justify-center overflow-hidden">
                        <img id="imagePreview" 
                             src="{{ $product->image ? Storage::url($product->image) : '' }}" 
                             class="w-full h-full object-cover {{ $product->image ? '' : 'hidden' }}">
                             
                        <span id="noImageText" class="text-neutral-400 text-xs {{ $product->image ? 'hidden' : '' }}">لا توجد صورة</span>
                    </div>

                    <input type="file" name="image" id="imageInput" accept="image/*"
                           onchange="previewImage(event)"
                           class="block w-full text-xs text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 hover:file:bg-neutral-200 cursor-pointer">
                </div>

                <button type="submit" 
                        class="w-full bg-neutral-900 text-white py-3 rounded-xl font-bold hover:bg-black transition shadow-lg shadow-neutral-200">
                    حفظ التغييرات
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const noImageText = document.getElementById('noImageText');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                noImageText.classList.add('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection