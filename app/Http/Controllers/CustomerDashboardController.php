<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // جلب بيانات الزبون الحالي مع بروفايله وطلباته
        $user = Auth::user()->load(['profile', 'orders']);
        
        return view('customer.dashboard', compact('user'));
    }
}