<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
 public function store(Request $request, $customer_id)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|numeric',
    ]);

    $product = \App\Models\Product::find($request->product_id);
    $totalPrice = $request->quantity * $product->price;

   DB::transaction(function () use ($request, $customer_id, $product, $totalPrice) {
        $invoice = \App\Models\Invoice::create([
            'customer_profile_id' => $customer_id,
            'total_amount' => $totalPrice,
        ]);

        \App\Models\InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product_name' => $product->name, // حفظ اسم المنتج
            'quantity' => $request->quantity,
            'price' => $product->price, // حفظ السعر المسجل للمنتج
        ]);

        $customer = \App\Models\CustomerProfile::find($customer_id);
        $customer->decrement('current_balance', $totalPrice);
    });

    return back()->with('success', 'تمت إضافة المنتج بنجاح');
}
}
