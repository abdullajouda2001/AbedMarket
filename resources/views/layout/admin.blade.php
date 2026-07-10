<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; background: #FFFFFF; color: #1f2937; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 border-l border-neutral-100 p-8 flex flex-col">
        <div class="text-lg font-bold tracking-tighter mb-16 text-neutral-900 italic">عابد ماركت</div>
        <nav class="space-y-1 flex-1">
            <a href="/admin/dashboard" class="block px-4 py-2.5 rounded-md bg-neutral-50 text-black text-sm font-medium transition">الرئيسية</a>
            <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded-md hover:bg-neutral-50 text-neutral-500 hover:text-black text-sm transition">الاقسام </a>
            <a href="{{ route('products.index') }}" class="block px-4 py-2.5 rounded-md hover:bg-neutral-50 text-neutral-500 hover:text-black text-sm transition">المنتجات</a>
         <a href="{{ route('admin.orders.index') }}" 
   class="block px-4 py-2.5 rounded-md hover:bg-neutral-50 text-neutral-500 hover:text-black text-sm transition">
   الطلبات
</a>   <a href="{{route('customer.index')}}" class="block px-4 py-2.5 rounded-md hover:bg-neutral-50 text-neutral-500 hover:text-black text-sm transition">الزباين</a>            
           
        </nav>
        
        <!-- Profile & Logout Section -->
        <div class="border-t border-neutral-100 pt-6">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 mb-6 hover:opacity-70 transition">
                <div class="w-8 h-8 rounded-full bg-neutral-900 text-white flex items-center justify-center text-[10px]">ع</div>
                <span class="text-xs font-medium">الملف الشخصي</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-[11px] text-neutral-400 hover:text-red-500 transition uppercase tracking-widest">تسجيل الخروج</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-16 overflow-y-auto">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>