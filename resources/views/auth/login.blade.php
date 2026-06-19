<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | عابد ماركت</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-white text-neutral-900">

    <div class="flex h-screen">
        <!-- القسم الأيسر: خلفية السوبر ماركت -->
        <div class="hidden lg:flex w-1/2 relative p-16 flex-col justify-between overflow-hidden">
            
            <!-- صورة السوبر ماركت خلفية أساسية -->
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1578916171728-46686eac8d58?q=80&w=2000')] bg-cover bg-center"></div>
            
            <!-- طبقة غامقة (Overlay) لضمان وضوح النص -->
            <div class="absolute inset-0 bg-black/60"></div>

            <div class="relative z-10 text-white">
                <h2 class="text-6xl font-bold tracking-tight">عابد ماركت</h2>
                <p class="mt-4 text-neutral-200 font-light tracking-[0.2em] uppercase text-xs">Premium Supermarket Chain</p>
                <div class="w-20 h-[2px] bg-white mt-10"></div>
                <p class="mt-10 text-xl font-light leading-relaxed max-w-sm text-neutral-100">
                    نحن هنا لنقدم لك تجربة تسوق لا تُنسى. الجودة، التنوع، والخدمة التي تستحقها.
                </p>
            </div>
            
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-px h-10 bg-white/30"></div>
                <div>
                    <p class="text-[11px] text-white font-bold uppercase tracking-widest">إدارة متكاملة</p>
                    <p class="text-[11px] text-neutral-300">نظام تحكم مرن واحترافي</p>
                </div>
            </div>
        </div>

        <!-- القسم الأيمن: نموذج الدخول -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-sm">
                <div class="mb-12">
                    <h3 class="text-3xl font-bold text-neutral-900">تسجيل الدخول</h3>
                    <p class="text-neutral-500 text-sm mt-3">أهلاً بك في لوحة تحكم عابد ماركت</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-10">
                    @csrf
                    
                    <div class="relative group">
                        <input type="email" name="email" required placeholder="" value="{{ old('email') }}"
                               class="w-full bg-transparent border-b border-neutral-300 py-3 outline-none focus:border-black transition-all peer">
                        <label class="absolute right-0 -top-5 text-[11px] font-bold text-neutral-400 uppercase tracking-widest transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-sm peer-placeholder-shown:text-neutral-400 peer-focus:-top-5 peer-focus:text-[11px] peer-focus:text-black">
                            البريد الإلكتروني
                        </label>
                    </div>

                    <div class="relative group">
                        <input type="password" name="password" required placeholder=""
                               class="w-full bg-transparent border-b border-neutral-300 py-3 outline-none focus:border-black transition-all peer">
                        <label class="absolute right-0 -top-5 text-[11px] font-bold text-neutral-400 uppercase tracking-widest transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-sm peer-placeholder-shown:text-neutral-400 peer-focus:-top-5 peer-focus:text-[11px] peer-focus:text-black">
                            كلمة المرور
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-black text-white py-4 font-bold tracking-widest uppercase text-[12px] hover:bg-neutral-800 transition duration-300">
                        دخول الإدارة
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>