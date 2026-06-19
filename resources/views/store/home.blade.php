<main>

    {{-- استدعاء ملف الـ head أو أي إعدادات أولية --}}
    @include('layoutstore.head')

    {{-- قسم البانر (السلايدر) --}}
    <div class="banner">
        <div class="container">
         

    {{-- قسم التصنيفات --}}
    <div class="category">
        <div class="container">
            <div class="category-item-container has-scrollbar">
                @foreach($categories as $category)
                <div class="category-item">
                    <div class="category-img-box">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="30">
                    </div>
                    <div class="category-content-box">
                        <div class="category-content-flex">
                            <h3 class="category-item-title">{{ $category->name }}</h3>
                            <p class="category-item-amount">({{ $category->count ?? 0 }})</p>
                        </div>
                        <a href="#" class="category-btn">Show all</a>
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
                        <h2 class="sidebar-title">Category</h2>
                        <button class="sidebar-close-btn" data-mobile-menu-close-btn><ion-icon name="close-outline"></ion-icon></button>
                    </div>
                    
                    <ul class="sidebar-menu-category-list">
                        @foreach($sidebarCategories as $cat)
                        <li class="sidebar-menu-category">
                            <button class="sidebar-accordion-menu" data-accordion-btn>
                                <div class="menu-title-flex">
                                    <p class="menu-title">{{ $cat->name }}</p>
                                </div>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="product-showcase">
                    <h3 class="showcase-heading">best sellers</h3>
                    <div class="showcase-wrapper">
                        <div class="showcase-container">
                            @foreach($bestSellers as $product)
                            <div class="showcase">
                                <a href="#" class="showcase-img-box">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="75" height="75" class="showcase-img">
                                </a>
                                <div class="showcase-content">
                                    <h4 class="showcase-title">{{ $product->name }}</h4>
                                    <div class="price-box">
                                        <del>${{ $product->old_price }}</del>
                                        <p class="price">${{ $product->price }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- قسم المنتجات الرئيسي (الذي كان مفقوداً) --}}
            <div class="product-main">
                <h2 class="title">All Products</h2>
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="showcase">
                        <div class="showcase-banner"><img src="{{ Storage::url($product->image) }}" 
     alt="{{ $product->name }}" 
     class="product-img" 
     style="height: 150px; width: 100%; object-fit: contain;">     </div>
                        <div class="showcase-content">
                            <a href="#" class="showcase-category">{{ $product->category->name ?? 'General' }}</a>
                            <a href="#">
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