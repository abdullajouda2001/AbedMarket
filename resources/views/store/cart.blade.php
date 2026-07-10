<main style="background-color: #fafafa; min-height: 100vh;">
    @include('layoutstore.head')

    <div class="product-container" style="padding-top: 50px;">
        <div class="container">
            {{-- الجانب الأيمن (التصنيفات) --}}
            <div class="sidebar has-scrollbar">
                <div class="sidebar-category">
                    <h2 class="sidebar-title" style="font-weight: 700; letter-spacing: 1px;">الاقسام </h2>
                    <ul class="sidebar-menu-category-list">
                        @foreach($sidebarCategories as $cat)
                        <li class="sidebar-menu-category" style="padding: 10px 0; border-bottom: 1px solid #eee;">
                            <p class="menu-title" style="cursor: pointer;">{{ $cat->name }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- المحتوى الرئيسي (السلة) --}}
            <div class="product-main">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                    <div>
                        <h2 class="title" style="font-size: 32px; font-weight: 800; color: #1a1a1a;">Shopping Cart</h2>
                        <span style="color: #888;">{{ count(session('cart', [])) }} Items in your bag</span>
                    </div>
                    <a href="{{ route('orders.index') }}" style="background: #f0f0f0; color: #333; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                        <ion-icon name="list-outline"></ion-icon> My Orders
                    </a>
                </div>
                
                <div class="cart-box" style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.03);">
                    @if(empty($cart))
                        <div style="text-align: center; padding: 80px 0;">
                            <h3>السلة فارغة</h3>
                            <a href="/" style="background: #1a1a1a; color: #fff; padding: 15px 40px; border-radius: 50px; text-decoration: none;">تسوّق الآن</a>
                        </div>
                    @else
                        {{-- جدول المنتجات --}}
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #f4f4f4; color: #aaa; text-transform: uppercase; font-size: 12px;">
                                    <th style="padding: 20px; text-align: left;">المنتج </th>
                                    <th style="padding: 20px; text-align: center;">السعر</th>
                                    <th style="padding: 20px; text-align: center;">الكمية</th>
                                    <th style="padding: 20px; text-align: center;">الكمية </th>
                                    <th style="padding: 20px; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $total += ($details['price'] * $details['quantity']); @endphp
                                    <tr>
                                        <td style="padding: 30px 20px;">{{ $details['name'] }}</td>
                                        <td style="padding: 30px 20px; text-align: center;">${{ number_format($details['price'], 2) }}</td>
                                        <td style="padding: 30px 20px; text-align: center;">{{ $details['quantity'] }}</td>
                                        <td style="padding: 30px 20px; text-align: center;">${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                        <td style="padding: 30px 20px; text-align: center;">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">REMOVE</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        {{-- نموذج بيانات التوصيل وإتمام الطلب --}}
                        <div style="margin-top: 50px; display: flex; justify-content: flex-end;">
                            <div style="width: 400px; border-top: 2px solid #f4f4f4; padding-top: 20px;">
                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    
                                    {{-- حقول إدخال البيانات للزائر أو المستخدم --}}
                                    <input type="text" name="customer_name" placeholder="الاسم الكامل" required style="width: 100%; padding: 12px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 8px;">
                                    <input type="text" name="customer_phone" placeholder="رقم الهاتف" required style="width: 100%; padding: 12px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 8px;">
                                    <input type="text" name="address" placeholder="عنوان التوصيل" required style="width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px;">

                                    <div style="display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 20px;">
                                        <span style="font-weight: 700;">Total</span>
                                        <span style="font-weight: 800; color: #27ae60;">${{ number_format($total, 2) }}</span>
                                    </div>

                                    <button type="submit" style="width: 100%; padding: 22px; background: #27ae60; color: white; border: none; border-radius: 12px; font-weight: 800; cursor: pointer;">
                                        إتمام الطلب الآن
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('layoutstore.footer')
</main>