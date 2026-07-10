<main>

    {{-- استدعاء ملف الـ head أو أي إعدادات أولية --}}
    @include('layoutstore.head')

    {{-- قسم التصنيفات --}}
    <div class="category">
       <div class="container">
    <div class="category-item-container has-scrollbar">
        @foreach($categories as $category)
        <div class="category-item">
            <div class="category-img-box">
                {{-- تأكد أن مسار الصورة في قاعدة البيانات يبدأ بـ 'storage/' إذا كانت في مجلد التخزين --}}
                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="30">
            </div>
            <div class="category-content-box">
                <div class="category-content-flex">
                    <h3 class="category-item-title">{{ $category->name }}</h3>
                    {{-- هنا التعديل: نستخدم products_count التي سيتم جلبها عبر withCount --}}
                    <p class="category-item-amount">({{ $category->products_count ?? 0 }})</p>
                </div>
                <a href="{{ route('category.show', $category->id) }}" class="category-btn">Show all</a>
                <!-- <a href="{{ route('products.search', ['category_id' => $category->id]) }}" class="category-btn">Show all</a> -->
            </div>
        </div>
        @endforeach
    </div>
</div>
    </div>

    {{-- قسم المنتجات (القائمة الجانبية + عرض المنتجات) --}}
    <div class="product-container">
        <div class="container">
            
            {{-- القائمة الجانبية (Sidebar) --}}
            <div class="sidebar has-scrollbar" data-mobile-menu>
                <div class="sidebar-category">
                    <div class="sidebar-top">
                        <h2 class="sidebar-title">الأقسام </h2>
                        <button class="sidebar-close-btn" data-mobile-menu-close-btn><ion-icon name="close-outline"></ion-icon></button>
                    </div>
                    
                    <ul class="sidebar-menu-category-list">
                        @foreach($sidebarCategories as $cat)
                        <li class="sidebar-menu-category">
                            <button class="sidebar-accordion-menu" data-accordion-btn>
                                <div class="menu-title-flex">
                                <a href="{{ route('category.show', $cat->id) }}" class="menu-title" style="text-decoration: none; color: inherit;">
    {{ $cat->name }}
</a> </div>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="product-showcase">
                    <!-- <h3 class="showcase-heading">best sellers</h3> -->
                   
                </div>
            </div>

            {{-- قسم المنتجات الرئيسي --}}
            <div class="product-main">
                <h2 class="title">All Products</h2>
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="showcase">
                        <div class="showcase-banner">
                            <a href="{{ route('product.show', $product->id) }}">
                                <img src="{{ Storage::url($product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-img" 
                                     style="height: 150px; width: 100%; object-fit: contain;">
                            </a>
                        </div>
                        <div class="showcase-content">
                            <a href="#" class="showcase-category">{{ $product->category->name ?? 'General' }}</a>
                            <a href="{{ route('product.show', $product->id) }}">
                                <h3 class="showcase-title">{{ $product->name }}</h3>
                            </a>
                            <div class="price-box">
                                <p class="price">${{ $product->price }}</p>
                                @if($product->old_price)
                                <del>${{ $product->old_price }}</del>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- استدعاء الفوتر --}}
    @include('layoutstore.footer')

</main>