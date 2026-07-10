<main style="background-color: #fafafa; min-height: 100%; padding-bottom: 50px;">
    @include('layoutstore.head')

    <style>
        .page-wrapper { max-width: 1200px; margin: 0 auto; padding: 20px; display: flex; gap: 30px; align-items: flex-start; }
        .search-input { width: 100%; padding: 12px 20px; border-radius: 12px; border: 1px solid #eee; outline: none; margin-bottom: 20px; transition: all 0.3s; }
        .search-input:focus { border-color: #333; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        
        @media (max-width: 768px) {
            .page-wrapper { flex-direction: column; }
            .sidebar { width: 100% !important; }
        }
    </style>

    <div class="product-container" style="padding-top: 30px;">
        <div class="page-wrapper">
            
            {{-- الجانب الأيمن --}}
            <div class="sidebar" style="width: 250px; flex-shrink: 0;">
                <div style="background: #fff; padding: 20px; border-radius: 20px; border: 1px solid #eee;">
                    <h2 style="font-size: 16px; font-weight: 700; margin-bottom: 15px;">حسابي</h2>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 10px 0; border-bottom: 1px solid #eee;">
                            <a href="{{ route('client.dashboard') }}" style="text-decoration: none; color: #333;">الرئيسية</a>
                        </li>
                        <li style="padding: 10px 0;">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="color: red; border:none; background:none; cursor:pointer; padding:0;">تسجيل الخروج</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- المحتوى الرئيسي --}}
            <div style="flex-grow: 1; width: 100%;">
                
                {{-- بطاقة الرصيد المعدلة --}}
                <div style="background: #fff; padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f4f4f4;">
                    <div><h2 style="font-size: 18px; font-weight: 800; margin: 0;">حسابي المالي</h2></div>
                    <div style="text-align: right;">
                        @php $balance = $customer->current_balance; @endphp
                        
                        <div style="font-size: 18px; font-weight: 700; color: {{ $balance > 0 ? '#27ae60' : ($balance < 0 ? '#e74c3c' : '#555') }};">
                            @if($balance > 0)
                                <span style="font-size: 12px; color: #888; display: block;">له في ذمتكم:</span>
                                {{ number_format($balance, 2) }} شيكل
                            @elseif($balance < 0)
                                <span style="font-size: 12px; color: #888; display: block;">عليه في ذمتكم:</span>
                                {{ number_format(abs($balance), 2) }} شيكل
                            @else
                                <span style="color: #555;">الحساب مصفّر (0.00)</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- الجدول مع السيرش --}}
                <div style="background: #fff; padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.03); border: 1px solid #f4f4f4;">
                    <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">سجل المعاملات</h2>
                    
                    <input type="text" id="transactionSearch" class="search-input" placeholder="🔍 ابحث عن فاتورة أو دفعة...">

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #f4f4f4; color: #aaa; font-size: 11px;">
                                    <th style="padding: 12px; text-align: right;">التاريخ</th>
                                    <th style="padding: 12px; text-align: center;">النوع</th>
                                    <th style="padding: 12px; text-align: center;">التفاصيل</th>
                                    <th style="padding: 12px; text-align: center;">القيمة</th>
                                </tr>
                            </thead>
                            <tbody id="transactionsBody">
                                @forelse($activities as $activity)
                                    <tr>
                                        <td style="padding: 15px; border-bottom: 1px solid #f9f9f9; font-size: 13px;">{{ $activity['date']->format('Y-m-d') }}</td>
                                        <td style="padding: 15px; text-align: center; border-bottom: 1px solid #f9f9f9;">
                                            <span style="padding: 4px 10px; border-radius: 8px; font-size: 10px; background: {{ $activity['type'] == 'invoice' ? '#fff3e0' : '#e8f5e9' }};">
                                                {{ $activity['type'] == 'invoice' ? 'بضاعة' : 'سداد' }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px; text-align: center; border-bottom: 1px solid #f9f9f9; font-size: 13px;">
                                            {{ $activity['type'] == 'invoice' ? $activity['data']->items->pluck('product_name')->implode(', ') : 'دفعة نقدية' }}
                                        </td>
                                        <td style="padding: 15px; text-align: center; border-bottom: 1px solid #f9f9f9; font-weight: 700; font-size: 13px;">
                                            {{ number_format($activity['data']->total_amount ?? $activity['data']->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" style="text-align: center; padding: 20px; color: #999;">لا يوجد عمليات مسجلة</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('transactionSearch').addEventListener('keyup', function() {
            let searchTerm = this.value.toLowerCase();
            let rows = document.querySelectorAll('#transactionsBody tr');
            
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>

    @include('layoutstore.footer')
</main>