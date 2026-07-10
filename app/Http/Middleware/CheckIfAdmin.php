<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق: هل المستخدم مسجل دخول؟ وهل رتبته 'admin'؟
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // إذا لم يكن أدمن، يتم تحويله لصفحة العميل مع رسالة خطأ
        return redirect()->route('client.dashboard')->with('error', 'ليس لديك صلاحية الدخول للوحة الإدارة');
    }
}