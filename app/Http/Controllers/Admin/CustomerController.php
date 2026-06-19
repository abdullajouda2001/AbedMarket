<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = CustomerProfile::with('user')->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'current_balance' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);
            
            CustomerProfile::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'current_balance' => $request->current_balance ?? 0.00,
            ]);
        });

        return redirect()->route('customer.index')->with('success', 'تم إضافة العميل بنجاح');
    }

    public function edit($id)
    {
        $customer = CustomerProfile::with('user')->findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }
public function update(Request $request, $id)
{
    $customer = CustomerProfile::findOrFail($id);
    
    // حساب القيمة النهائية
    // إذا كان النوع "دين" (debit) نضرب القيمة في -1، وإلا تبقى كما هي
    $finalBalance = ($request->balance_type === 'debit') 
                    ? -abs($request->amount) 
                    : abs($request->amount);

    DB::transaction(function () use ($request, $customer, $finalBalance) {
        $customer->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'current_balance' => $finalBalance, // هنا الحفظ الأوتوماتيكي
        ]);
    });

    return redirect()->route('customer.index')->with('success', 'تم التحديث بنجاح');
}
 public function show($id)
{
    $customer = \App\Models\CustomerProfile::with(['user', 'invoices.items', 'payments'])->findOrFail($id);
    $products = \App\Models\Product::all(); // جلب كل المنتجات
    
    $activities = collect()
        ->concat($customer->invoices->map(fn($i) => ['type' => 'invoice', 'data' => $i, 'date' => $i->created_at]))
        ->concat($customer->payments->map(fn($p) => ['type' => 'payment', 'data' => $p, 'date' => $p->created_at]))
        ->sortByDesc('date');

    return view('admin.customer.show', compact('customer', 'activities', 'products'));
}

    public function destroy($id) 
    {
        $customer = CustomerProfile::findOrFail($id);
        // حذف المستخدم المرتبط (سيحذف البروفايل تلقائياً إذا كان لديك onDelete cascade)
        if ($customer->user) {
            $customer->user->delete();
        }
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'تم الحذف');
    }
}