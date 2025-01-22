<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CancelOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class ClientOrdersController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $orders = Order::query()
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('id')
            ->get();
        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('client.orders.show', compact('order'));
    }

    public function cancelOrder(CancelOrderRequest $request, Order $order)
    {
        if ($order->status != 'pending') {
            return redirect()->back()->with('error', __('client.cancelOnlyPending'));
        }

        $order->update(['status' => $request->validated()['status']]);
        return redirect(route('client.orders.index'))->with('success', __('client.orderCanceled'));
    }
}
