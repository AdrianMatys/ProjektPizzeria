<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Pizza;
use App\Models\CartItem;
use http\Env\Response;
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

        $item = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
            ],
            [
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Dodano do koszyka', 'item' => $item]);
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
