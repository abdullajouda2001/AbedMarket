<?php

use App\Http\Middleware\CheckRole; // تم تصحيح المسار هنا
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. تحديد وجهة الضيوف (غير المسجلين) عند محاولة دخول مسارات محمية
        $middleware->redirectGuestsTo(function (Request $request) {
            // إذا كان المسار يبدأ بـ admin/ ، نوجهه لمسار الدخول الخاص بالأدمن (login)
            if ($request->is('admin/*')) {
                return route('login'); 
            }
            
            // في أي حالة أخرى (بما فيها client/*)، نوجهه لصفحة دخول العميل
            return route('client.login');
        });

        // 2. تسجيل الـ Middleware الخاص بالصلاحيات (CheckRole)
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();