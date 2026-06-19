<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{


public function store(Request $request, $customer_id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request, $customer_id) {
            // 1. تسجيل عملية القبض
            Payment::create([
                'customer_profile_id' => $customer_id,
                'amount' => $request->amount,
            ]);

            // 2. زيادة رصيد العميل (يقل الدين أو يزيد الرصيد)
            $customer = CustomerProfile::findOrFail($customer_id);
            $customer->increment('current_balance', $request->amount);
        });

        return back()->with('success', 'تم تسجيل الدفعة بنجاح');
    }}
