<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogCreateNewUserAction;
use App\Actions\Logs\LogNewOrderAction;
use App\Actions\Logs\LogUpdateIngredientAction;
use App\Models\Cart;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
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

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
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

    public function order(Request $request, int $user_id, LogNewOrderAction $logNewOrderAction)
    {
        $totalPrice = 0;

        if (!$user_id) {
            return response()->json(['error' => 'Aby złożyć zamówienie musisz się zalogować.'], 401);
        }

        $cart = Cart::query()->where('user_id', $user_id)->first();
        $cartItems = CartItem::query()
            ->where('cart_id', $cart->id)
            ->get();

        if($cartItems->isEmpty()){
            return response()->json(['error' => 'Twój koszyk jest pusty.']);
        }

        $order = Order::create([
            'user_id' => $user_id,
            'status' => 'pending',
            'total_price' => 0,
        ]);

        foreach ($cartItems as $cartItem){
            $totalPrice += $cartItem->price * $cartItem->quantity;

            OrderItem::create(
                [
                    'order_id' => $order->id,
                    'item_type' => $cartItem->item_type,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]
            );

            $ingredients = $cartItem->item->ingredients;

            foreach ($ingredients as $ingredient) {
                $totalQuantity = $ingredient->quantityOnPizza * $cartItem->quantity;
                Ingredient::query()
                    ->where('id', $ingredient->id)
                    ->decrement('quantity', $totalQuantity);
                $dbIngredient = Ingredient::query()
                    ->where('id', $ingredient->id)
                    ->first();
                $this->checkLowStock($dbIngredient->quantity);
            }

        }


        CartItem::query()
            ->where('cart_id', $cart->id)
            ->delete();
        $order->update(['total_price' => $totalPrice]);

        $logNewOrderAction->execute($user_id, ['cart_id' => $cart->id]);


        return view('client.orders.completed', compact('cartItems'));
    }

    public function index(Request $request, int $user_id)
    {

        $cart = Cart::query()
            ->with('items.item')
            ->where('user_id', $user_id)
            ->first();
        if (!$cart) {
            return response()->json(['message' => 'Koszyk jest pusty']);
        }
        return response()->json(['cart' => $cart]);
    }

    private function checkLowStock(int $quantity)
    {
        if ($quantity > 1000) {
            Artisan::call('notify:low-stock');
        }
    }
}
