<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // التحقق إذا كان المستخدم مسجلاً ولديه الدور المطلوب
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // إذا لم يكن لديه صلاحية، نوجهه للصفحة المناسبة
        if ($role === 'admin') {
            return redirect()->route('client.login')->withErrors(['email' => 'غير مسموح لك بدخول لوحة الإدارة.']);
        }

        return redirect()->route('login')->withErrors(['email' => 'غير مسموح لك بدخول بوابة العملاء.']);
    }
}