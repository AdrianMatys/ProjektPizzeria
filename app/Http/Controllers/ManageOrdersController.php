<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ManageOrdersController extends Controller
{
    public function index(){
        $orders = Order::query()->get();
        return view('management.employee.orders.index', compact('orders'));
    }
    public function show(Order $order){

        return view('management.employee.orders.show', compact('order'));
    }
}
