@extends('layout.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-2xl font-medium">المنتجات</h1>
        
        <a href="{{ route('products.create') }}" 
           class="bg-black text-white px-6 py-2 text-[11px] font-bold uppercase tracking-widest rounded-sm hover:bg-neutral-800 transition">
           إضافة منتج جديد
        </a>
    </div>

    <div class="bg-white rounded-lg border border-neutral-100">
        @foreach($products as $product)
        <div class="flex items-center justify-between p-6 border-b border-neutral-100 last:border-0">
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-100 rounded overflow-hidden flex-shrink-0">
                    
                @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <span class="text-sm font-medium block">{{ $product->name }}</span>
                    <span class="text-[10px] text-neutral-400 uppercase">{{ $product->category?->name ?? 'بدون قسم' }}</span>
                </div>
            </div>

            <div style="display: inline-flex !important; align-items: center !important; gap: 15px !important; flex-shrink: 0 !important;">
                
                <a href="{{ route('products.edit', $product->id) }}" 
                   style="font-size: 11px !important; font-weight: bold !important; color: #737373 !important; text-decoration: none !important; white-space: nowrap !important;">
                   تعديل
                </a>
                
                <span style="color: #d4d4d4 !important; font-size: 14px !important; font-weight: 300;">|</span>

                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin: 0 !important; padding: 0 !important; display: inline-flex !important; align-items: center !important;">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('هل أنت متأكد؟')"
                            style="font-size: 11px !important; font-weight: bold !important; color: #ef4444 !important; background: none !important; border: none !important; cursor: pointer !important; white-space: nowrap !important;">
                        حذف
                    </button>
                </form>
            </div> 
        </div>
        @endforeach
    </div>
</div>
@endsection