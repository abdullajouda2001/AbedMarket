<main style="background-color: #f9f9f9; min-height: 100vh; padding-bottom: 50px;">
    @include('layoutstore.head')

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <header style="margin-bottom: 40px; border-right: 5px solid #27ae60; padding-right: 20px;">
            <h1 style="font-size: 2.5rem; color: #1a1a1a; margin: 0;">{{ $category->name }}</h1>
            <p style="color: #666; margin-top: 10px;">استعرض أحدث المنتجات في هذا القسم</p>
        </header>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px;">
            @forelse($category->products as $product)
                <div class="product-card" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
                    
                    <div style="height: 200px; overflow: hidden;">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div style="padding: 20px;">
                        <h3 style="font-size: 1.2rem; margin-bottom: 10px; color: #333;">{{ $product->name }}</h3>
                        <p style="font-weight: bold; color: #27ae60; font-size: 1.1rem; margin-bottom: 20px;">${{ number_format($product->price, 2) }}</p>
                        
                        <a href="{{ route('product.show', $product->id) }}" 
                           style="display: block; text-align: center; background: #1a1a1a; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s;">
                           عرض التفاصيل
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #fff; border-radius: 15px;">
                    <p style="font-size: 1.2rem; color: #888;">لا توجد منتجات في هذا القسم حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>

    @include('layoutstore.footer')
</main>