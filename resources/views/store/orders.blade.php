<main style="background-color: #fafafa; min-height: 100vh; padding-bottom: 50px;">
    @include('layoutstore.head')

    <div class="product-container" style="padding-top: 50px;">
        <div class="container">
            
            {{-- الـ Sidebar كما في السلة --}}
          <div class="sidebar has-scrollbar">
    <div class="sidebar-category">
        <h2 class="sidebar-title" style="font-weight: 700;">حسابي</h2>
        <ul class="sidebar-menu-category-list">
            {{-- رابط الملف الشخصي --}}
            <li class="sidebar-menu-category">
                <a href="{{ route('profile.edit') }}" 
                   style="text-decoration: none; color: {{ request()->routeIs('profile.edit') ? 'var(--orange-web)' : '#333' }}; font-weight: 600; display: block; padding: 10px 0;">
                   الملف الشخصي
                </a>
            </li>

            <!-- {{-- رابط الطلبات --}}
            <li class="sidebar-menu-category">
                <a href="{{ route('client.orders') }}" 
                   style="text-decoration: none; color: {{ request()->routeIs('client.orders') ? 'var(--orange-web)' : '#333' }}; font-weight: 600; display: block; padding: 10px 0;">
                   طلباتي
                </a>
            </li> -->

            {{-- رابط الإعدادات (بافتراض وجود مسار للإعدادات) --}}
            <!-- <li class="sidebar-menu-category">
                <a href="#" 
                   style="text-decoration: none; color: #333; font-weight: 600; display: block; padding: 10px 0;">
                   الإعدادات
                </a>
            </li> -->
        </ul>
    </div>
</div>
            {{-- محتوى الطلبات الرئيسي --}}
            <div class="product-main">
    <h2 class="title" style="font-size: 32px; font-weight: 800; margin-bottom: 40px; color: #1a1a1a;">طلباتي</h2>

    @if($orders->isEmpty())
        <div style="text-align: center; padding: 80px; background: #fff; border-radius: 20px;">
            <div style="font-size: 50px; margin-bottom: 20px;">📦</div>
            <h3 style="font-weight: 700;">لا توجد طلبات سابقة</h3>
            <p style="color: #888; margin-top: 10px;">لم تقم بأي عملية شراء بعد. ابدأ بالتسوق الآن!</p>
            <a href="{{ route('home') }}" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #1a1a1a; color: #fff; border-radius: 50px; text-decoration: none;">تسوّق الآن</a>
        </div>
    @else
        @foreach($orders as $order)
        <div style="background: #fff; padding: 30px; border-radius: 20px; margin-bottom: 25px; box-shadow: 0 10px 20px rgba(0,0,0,0.03); border-right: 5px solid {{ $order->status == 'completed' ? '#48bb78' : '#e67e22' }};">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <span style="color: #aaa; font-size: 12px; text-transform: uppercase;">رقم الطلب</span>
                    <div style="font-weight: 800; font-size: 18px;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div style="text-align: right;">
                    <span style="color: #aaa; font-size: 12px; text-transform: uppercase;">الحالة</span>
                    <div style="font-weight: 700; color: {{ $order->status == 'completed' ? '#48bb78' : '#e67e22' }};">
                        {{ $order->status == 'completed' ? 'مكتمل' : 'قيد المعالجة' }}
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f4f4f4; padding-top: 20px;">
                <div>
                    <span style="color: #aaa; font-size: 12px;">تاريخ الطلب</span>
                    <div style="font-weight: 600;">{{ $order->created_at->format('Y/m/d') }}</div>
                </div>
                <div style="font-size: 20px; font-weight: 800;">
                    ${{ number_format($order->total_price, 2) }}
                </div>
                
                {{-- الربط بصفحة تفاصيل الطلب --}}
                <a href="{{ route('client.order.show', $order->id) }}" 
                   style="background: #f4f4f4; color: #333; padding: 10px 20px; border-radius: 50px; font-weight: 600; text-decoration: none; transition: 0.3s;">
                   عرض التفاصيل
                </a>
            </div>
        </div>
        @endforeach
    @endif
</div>
        </div>
    </div>

    @include('layoutstore.footer')
</main>