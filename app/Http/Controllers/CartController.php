<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $user_id = $request->user_id;

        if (!$user_id) {
            return response()->json(['error' => 'Nie znaleziono użytkownika. Upewnij się, że jesteś zalogowany.'], 401);
        }

        $cart = Cart::query()->firstOrCreate(['user_id' => $user_id]);

        $cartItem = CartItem::query()->where(
            [
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
            ])
            ->first();

        if($cartItem){
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }else{
            $cartItem = CartItem::query()->create([
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Dodano do koszyka', 'item' => $cartItem]);
    }

    public function order(Request $request, int $user_id){

        if (!$user_id) {
            return response()->json(['error' => 'Nie znaleziono użytkownika. Upewnij się, że jesteś zalogowany.'], 401);
        }

        $cart = Cart::query()->where('user_id', $user_id)->first();

        $cartItems = CartItem::query()
            ->where('cart_id', $cart->id)
            ->get();
        $totalPrice = 0;
        $data = [
            'user_id' => $user_id,
            'status' => 'pending',
            'total_price' => 0,
        ];
        $order = Order::create($data);
        if($cartItems){
            foreach ($cartItems as $item){
                $itemData = [
                    'order_id' => $order->id,
                    'item_type' => $item->item_type,
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ];
                $totalPrice += $item->price * $item->quantity;
                OrderItem::create($itemData);
            }
            CartItem::query()
                ->where('cart_id', $cart->id)
                ->delete();
            $order->update(['total_price' => $totalPrice]);
        }else{
            return response()->json(['error' => 'Twój koszyk jest pusty. Upewnij się, że jesteś zalogowany i koszyk nie jest pusty.'], 401);
        }
        return view('client.order.completed', compact('cartItems'));
    }

    public function index(Request $request, int $user_id){

        $cart = Cart::query()
            ->with('items.item')
            ->where('user_id', $user_id)
            ->first();
        if(!$cart){
            return response()->json(['message' => 'Koszyk jest pusty']);
        }
        return response()->json(['cart' => $cart]);
    }
}
