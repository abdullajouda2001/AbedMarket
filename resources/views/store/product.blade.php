<main>
    @include('layoutstore.head')

    <div class="product-container">
        <div class="container">

            {{-- نفس الـ Sidebar الموجود في صفحتك الرئيسية --}}
            <div class="sidebar has-scrollbar">
                <div class="sidebar-category">
                    <h2 class="sidebar-title">Categories</h2>
                    <ul class="sidebar-menu-category-list">
                        @foreach($sidebarCategories as $cat)
                        <li class="sidebar-menu-category">
                            <p class="menu-title">{{ $cat->name }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- تفاصيل المنتج الرئيسي --}}
            <div class="product-main">
                <div class="product-showcase" style="background: #fff; padding: 30px; border-radius: 15px; display: flex; flex-wrap: wrap; gap: 40px;">

                    {{-- صورة المنتج --}}
                    <div class="showcase-banner" style="flex: 1; min-width: 300px;">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 10px;">
                    </div>

                    {{-- معلومات المنتج --}}
                    <div class="showcase-content" style="flex: 1; min-width: 300px;">
                        <p class="showcase-category" style="color: var(--orange-web);">{{ $product->category->name ?? 'General' }}</p>
                        <h1 class="showcase-title" style="font-size: 32px; margin: 15px 0;">{{ $product->name }}</h1>

                        <div class="price-box" style="font-size: 24px; font-weight: 700; margin-bottom: 20px;">
                            <p class="price">${{ $product->price }}</p>
                            @if($product->old_price)
                            <del style="color: #999; font-size: 18px;">${{ $product->old_price }}</del>
                            @endif
                        </div>

                        <p style="color: #777; margin-bottom: 30px;">{{ $product->description ?? 'لا يوجد وصف متاح لهذا المنتج حالياً.' }}</p>

                        {{-- نموذج إضافة للسلة (سنربطه لاحقاً) --}}
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div style="display: flex; gap: 15px;">
                                <input type="number" name="quantity" value="1" min="1" style="width: 60px; padding: 10px; border: 1px solid #ddd;">
                                <button type="submit" style="background: var(--eerie-black); color: white; padding: 10px 30px; border-radius: 5px; cursor: pointer;">
                                    Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('layoutstore.footer')
</main>