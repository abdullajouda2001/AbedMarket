<main style="background-color: #f9f9f9; min-height: 100vh; padding-bottom: 50px;">
    @include('layoutstore.head')

    <div class="container" style="padding: 40px 0;">
        @if(isset($product))
            <div style="display: flex; gap: 40px; flex-wrap: wrap; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                
                <!-- صورة المنتج -->
                <div style="flex: 1; min-width: 300px;">
                    <img src="{{ Storage::url($product->image) }}" 
                         alt="{{ $product->name }}" 
                         style="width: 100%; height: auto; border-radius: 10px; object-fit: contain;">
                </div>

                <!-- تفاصيل المنتج -->
                <div style="flex: 1; min-width: 300px;">
                    <h1 style="color: #333; margin-bottom: 10px;">{{ $product->name }}</h1>
                    <p style="font-size: 24px; color: #e67e22; font-weight: bold; margin-bottom: 20px;">
                        ${{ $product->price }}
                    </p>
                    <p style="color: #666; line-height: 1.6; margin-bottom: 30px;">
                        {{ $product->description ?? 'لا يوجد وصف للمنتج حالياً.' }}
                    </p>

                    <!-- نموذج الإضافة للسلة -->
                    <form action="{{ route('cart.add') }}" method="POST" style="display: flex; gap: 15px; align-items: center;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- اختيار الكمية -->
                        <div style="display: flex; align-items: center;">
                            <label style="margin-right: 10px; font-weight: bold;">الكمية:</label>
                            <input type="number" name="quantity" value="1" min="1" 
                                   style="width: 60px; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>

                        <!-- زر الإضافة -->
                        <button type="submit" 
                                style="padding: 10px 25px; background-color: #000; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                            إضافة إلى السلة
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 50px;">
                <h1 style="color: blue;">المنتج غير موجود أو حدث خطأ في جلب البيانات!</h1>
            </div>
        @endif
    </div>

    @include('layoutstore.footer')
</main>