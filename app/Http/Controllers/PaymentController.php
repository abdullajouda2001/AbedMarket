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
    }// دالة حذف الدفعة
// public function destroy($id)
// {
//     $payment = \App\Models\Payment::findOrFail($id);
//     $customer = \App\Models\CustomerProfile::findOrFail($payment->customer_profile_id);

//     // عكس عملية السداد: لأن الدفعة كانت تضيف للرصيد (تقليل المديونية)، 
//     // عند حذفها يجب أن نخصم المبلغ من الرصيد (زيادة المديونية)
//     $customer->decrement('current_balance', $payment->amount);

//     $payment->delete();
//     return back()->with('success', 'تم حذف الدفعة بنجاح');
// }

// دالة تعديل الدفعة
public function update(Request $request, $id)
{
    $payment = \App\Models\Payment::findOrFail($id);
    $customer = \App\Models\CustomerProfile::findOrFail($payment->customer_profile_id);

    // 1. استعادة الرصيد القديم (عكس أثر الدفعة القديمة)
    $customer->decrement('current_balance', $payment->amount);

    // 2. تحديث مبلغ الدفعة
    $payment->update(['amount' => $request->amount]);

    // 3. إضافة الرصيد الجديد
    $customer->increment('current_balance', $payment->amount);

    return back()->with('success', 'تم تعديل الدفعة بنجاح');
}

    public function destroy($id)
{
    $payment = \App\Models\Payment::findOrFail($id);
    $customer = \App\Models\CustomerProfile::findOrFail($payment->customer_profile_id);

    // عكس عملية السداد: 
    // إذا كانت الدفعة تزيد الرصيد، عند حذفها يجب خصم المبلغ
    $customer->decrement('current_balance', $payment->amount);

    $payment->delete();

    return back()->with('success', 'تم حذف الدفعة وتعديل رصيد العميل');
}
    }
