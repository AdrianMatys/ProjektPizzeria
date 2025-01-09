<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class ManageOrdersController extends Controller
{

    public function index(){
        $groupedOrders = Order::query()->get()->groupBy('status');
        return view('management.employee.orders.index', compact('groupedOrders'));
    }
    public function show(Order $order){
        return view('management.employee.orders.show', compact('order'));
    }
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order){
        $order->update(['status' => $request->validated()['status']]);
        return redirect()->back()->with('success', 'Status zamówienia został zaktualizowany');
    }
}
