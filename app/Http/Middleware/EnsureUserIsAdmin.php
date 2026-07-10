<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    // إذا لم يكن أدمن، نطرده (إما للوجن العميل أو للرئيسية)
    return redirect()->route('client.login')->with('error', 'ليس لديك صلاحية الوصول.');
}
}
