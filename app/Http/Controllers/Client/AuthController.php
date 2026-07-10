<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // التحقق: هل هو "customer"؟
            // هنا نتحقق من الـ role ومن وجود البروفايل لضمان الأمان
            if ($user->role === 'customer' && $user->customerProfile) {
                return redirect()->route('client.dashboard');
            }

            // إذا كان أدمن أو لا يملك بروفايل، نطرده فوراً
            Auth::logout();
            return back()->withErrors([
                'email' => 'هذا الحساب مخصص للعملاء فقط ولا يمكنك الدخول من هنا.'
            ]);
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.'
        ]);
    }
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('client.login');
}
    }