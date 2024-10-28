<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:create order', ['only' => ['create', 'store']]);
        $this->middleware('can:read order', ['only' => ['show', 'index']]);
        $this->middleware('can:edit order', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete order', ['only' => ['destroy']]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        // التحقق من القيمة المدخلة للحالة
        $validated = $request->validate([
            'status' => 'required|in:معلق,غير منجز,مكتمل,ملغي',
        ]);

        // تحديث حالة الطلب
        $order->status = $validated['status'];
        $order->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.orders.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // $order = Order::findOrFail();
        return view('pages.apps.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
